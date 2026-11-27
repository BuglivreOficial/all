<?php
namespace Core\RateLimit;

use Core\Redis\RedisClient;
use Predis\Client;
use Throwable;

/**
 * Limitador de taxa com janela fixa.
 *
 * Usa o **Redis** quando disponível (INCR + EXPIRE atômicos via script Lua) e,
 * caso contrário, degrada para arquivos em `storage/rate_limit/<hash>.json`
 * (controle com `flock`). A interface `hit()` é idêntica nos dois modos, então o
 * projeto continua funcionando sem Redis.
 */
class RateLimiter {
    /** Incrementa o contador e define a expiração apenas na primeira tentativa. */
    private const SCRIPT = <<<'LUA'
        local current = redis.call('INCR', KEYS[1])
        if current == 1 then
            redis.call('EXPIRE', KEYS[1], ARGV[1])
        end
        return {current, redis.call('TTL', KEYS[1])}
        LUA;

    private string $directory;
    private ?Client $redis;

    public function __construct(?string $directory = null, ?Client $redis = null) {
        $this->directory = $directory ?? storage_path('rate_limit');
        $this->redis = $redis ?? RedisClient::connection();

        if ($this->redis === null && !is_dir($this->directory)) {
            @mkdir($this->directory, 0775, true);
        }
    }

    /**
     * Registra uma tentativa para a chave e devolve o estado da janela.
     *
     * @return array{allowed: bool, limit: int, remaining: int, retry_after: int, reset_at: int}
     */
    public function hit(string $key, int $maxAttempts, int $decaySeconds): array {
        if ($this->redis !== null) {
            try {
                return $this->hitRedis($key, $maxAttempts, $decaySeconds);
            } catch (Throwable $e) {
                // Redis caiu no meio da execução: cai para o arquivo pelo resto da requisição.
                logger()->warning('Falha no limitador via Redis; usando arquivo.', [
                    'error' => $e->getMessage(),
                ]);
                $this->redis = null;
                if (!is_dir($this->directory)) {
                    @mkdir($this->directory, 0775, true);
                }
            }
        }

        return $this->hitFile($key, $maxAttempts, $decaySeconds);
    }

    /**
     * @return array{allowed: bool, limit: int, remaining: int, retry_after: int, reset_at: int}
     */
    private function hitRedis(string $key, int $maxAttempts, int $decaySeconds): array {
        $result = $this->redis->eval(
            self::SCRIPT,
            1,
            'rate_limit:' . hash('sha256', $key),
            $decaySeconds
        );

        $now = time();
        $count = (int) ($result[0] ?? 0);
        $ttl = max(0, (int) ($result[1] ?? 0));

        return [
            'allowed' => $count <= $maxAttempts,
            'limit' => $maxAttempts,
            'remaining' => max(0, $maxAttempts - $count),
            'retry_after' => $ttl,
            'reset_at' => $now + $ttl,
        ];
    }

    /**
     * @return array{allowed: bool, limit: int, remaining: int, retry_after: int, reset_at: int}
     */
    private function hitFile(string $key, int $maxAttempts, int $decaySeconds): array {
        $now = time();
        $state = ['count' => 0, 'reset_at' => $now + $decaySeconds];

        $handle = @fopen($this->file($key), 'c+');
        if ($handle === false) {
            // Sem permissão de escrita: não bloqueia a requisição.
            return $this->result($state, $maxAttempts, $now);
        }

        try {
            flock($handle, LOCK_EX);

            $stored = json_decode(stream_get_contents($handle) ?: '', true);
            if (is_array($stored) && (int) ($stored['reset_at'] ?? 0) > $now) {
                $state['count'] = (int) ($stored['count'] ?? 0);
                $state['reset_at'] = (int) $stored['reset_at'];
            }

            $state['count']++;

            rewind($handle);
            ftruncate($handle, 0);
            fwrite($handle, json_encode($state));
            fflush($handle);
            flock($handle, LOCK_UN);
        } finally {
            fclose($handle);
        }

        return $this->result($state, $maxAttempts, $now);
    }

    /**
     * @param array{count: int, reset_at: int} $state
     * @return array{allowed: bool, limit: int, remaining: int, retry_after: int, reset_at: int}
     */
    private function result(array $state, int $maxAttempts, int $now): array {
        return [
            'allowed' => $state['count'] <= $maxAttempts,
            'limit' => $maxAttempts,
            'remaining' => max(0, $maxAttempts - $state['count']),
            'retry_after' => max(0, $state['reset_at'] - $now),
            'reset_at' => $state['reset_at'],
        ];
    }

    private function file(string $key): string {
        return $this->directory . '/' . hash('sha256', $key) . '.json';
    }
}
