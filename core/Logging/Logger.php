<?php
namespace Core\Logging;

class Logger {
    public const DEBUG    = 'debug';
    public const INFO     = 'info';
    public const WARNING  = 'warning';
    public const ERROR    = 'error';
    public const CRITICAL = 'critical';

    private static ?Logger $instance = null;

    private string $directory;

    public function __construct(?string $directory = null) {
        $this->directory = $directory ?? storage_path('logs');
        if (!is_dir($this->directory)) {
            @mkdir($this->directory, 0775, true);
        }
    }

    public static function instance(): self {
        return self::$instance ??= new self();
    }

    public static function setInstance(self $logger): void {
        self::$instance = $logger;
    }

    public function debug(string $message, array $context = []): void {
        $this->log(self::DEBUG, $message, $context);
    }

    public function info(string $message, array $context = []): void {
        $this->log(self::INFO, $message, $context);
    }

    public function warning(string $message, array $context = []): void {
        $this->log(self::WARNING, $message, $context);
    }

    public function error(string $message, array $context = []): void {
        $this->log(self::ERROR, $message, $context);
    }

    public function critical(string $message, array $context = []): void {
        $this->log(self::CRITICAL, $message, $context);
    }

    /**
     * Escreve uma linha no arquivo diário storage/logs/app-YYYY-MM-DD.log
     */
    public function log(string $level, string $message, array $context = []): void {
        $suffix = '';
        if ($context !== []) {
            $suffix = ' ' . json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $line = sprintf(
            "[%s] %s: %s%s%s",
            date('Y-m-d H:i:s'),
            strtoupper($level),
            $message,
            $suffix,
            PHP_EOL
        );

        @file_put_contents(
            $this->directory . '/app-' . date('Y-m-d') . '.log',
            $line,
            FILE_APPEND | LOCK_EX
        );
    }
}
