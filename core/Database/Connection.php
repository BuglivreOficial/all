<?php
namespace Core\Database;

use Core\Support\Env;
use PDO;
use PDOException;
use RuntimeException;

class Connection {
    private static ?PDO $pdo = null;

    /**
     * Retorna uma conexão PDO única (lazy) para o banco configurado no .env.
     */
    public static function pdo(): PDO {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $host = Env::get('DB_HOST', '127.0.0.1');
        $port = Env::get('DB_PORT', '3306');
        $database = Env::get('DB_DATABASE', 'buglivre');
        $username = Env::get('DB_USERNAME', 'root');
        $password = Env::get('DB_PASSWORD', '');
        $charset = Env::get('DB_CHARSET', 'utf8mb4');

        $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=$charset";

        try {
            self::$pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Falha ao conectar no banco de dados: ' . $e->getMessage(), 0, $e);
        }

        return self::$pdo;
    }
}
