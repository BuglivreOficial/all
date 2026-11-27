<?php
namespace Core\Redis;

use Core\Support\Env;
use Predis\Client;
use Throwable;

/**
 * Conexão Redis única (lazy singleton) via Predis.
 *
 * A conexão é opcional: só é criada quando REDIS_ENABLED estiver ativo e a
 * biblioteca `predis/predis` estiver instalada. Se o servidor estiver
 * indisponível, devolve `null` (os consumidores degradam para o armazenamento
 * em arquivo). Assim o projeto continua portável, sem depender do Redis.
 */
class RedisClient {
    private static ?Client $client = null;
    private static bool $resolved = false;

    /**
     * Devolve o cliente Predis conectado, ou `null` se o Redis estiver
     * desabilitado ou inacessível.
     */
    public static function connection(): ?Client {
        if (self::$resolved) {
            return self::$client;
        }
        self::$resolved = true;

        if (!config_bool('REDIS_ENABLED', false) || !class_exists(Client::class)) {
            return self::$client = null;
        }

        $timeout = (float) Env::get('REDIS_TIMEOUT', 2.5);

        $parameters = [
            'scheme' => (string) Env::get('REDIS_SCHEME', 'tcp'), // tcp | tls | unix
            'host'   => (string) Env::get('REDIS_HOST', '127.0.0.1'),
            'port'   => (int) Env::get('REDIS_PORT', 6379),
            'timeout' => $timeout,
            'read_write_timeout' => $timeout,
        ];

        $username = Env::get('REDIS_USERNAME');
        if ($username !== null && $username !== '') {
            $parameters['username'] = (string) $username;
        }

        $password = Env::get('REDIS_PASSWORD');
        if ($password !== null && $password !== '') {
            $parameters['password'] = (string) $password;
        }

        $database = Env::get('REDIS_DB');
        if ($database !== null && $database !== '') {
            $parameters['database'] = (int) $database;
        }

        $options = [];
        $prefix = (string) Env::get('REDIS_PREFIX', 'buglivre:');
        if ($prefix !== '') {
            $options['prefix'] = $prefix;
        }

        try {
            $client = new Client($parameters, $options);
            $client->connect();
            $client->ping();
        } catch (Throwable $e) {
            logger()->warning('Redis indisponível; usando armazenamento alternativo.', [
                'error' => $e->getMessage(),
            ]);
            return self::$client = null;
        }

        return self::$client = $client;
    }
}
