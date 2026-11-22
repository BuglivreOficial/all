<?php
/**
 * Executa o schema do banco de dados.
 * Cria o banco (se necessário) e aplica database/schema.sql.
 *
 * Uso: php database/migrate.php
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Core\Database\Connection;
use Core\Support\Env;

Env::load(dirname(__DIR__) . '/.env');

$host = Env::get('DB_HOST', '127.0.0.1');
$port = Env::get('DB_PORT', '3306');
$database = Env::get('DB_DATABASE', 'buglivre');
$username = Env::get('DB_USERNAME', 'root');
$password = Env::get('DB_PASSWORD', '');
$charset = Env::get('DB_CHARSET', 'utf8mb4');

// Garante que o banco exista antes de conectar via Connection (o DSN inclui o dbname).
try {
    $server = new PDO("mysql:host=$host;port=$port;charset=$charset", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $server->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
} catch (Throwable $e) {
    fwrite(STDERR, 'Não foi possível criar/verificar o banco: ' . $e->getMessage() . "\n");
    exit(1);
}

$sql = file_get_contents(__DIR__ . '/schema.sql');

if ($sql === false) {
    fwrite(STDERR, "Não foi possível ler database/schema.sql\n");
    exit(1);
}

$statements = array_filter(array_map('trim', explode(';', $sql)));

try {
    $pdo = Connection::pdo();
    foreach ($statements as $statement) {
        $pdo->exec($statement);
    }
    fwrite(STDOUT, "Migração concluída com sucesso.\n");
    exit(0);
} catch (Throwable $e) {
    fwrite(STDERR, 'Erro na migração: ' . $e->getMessage() . "\n");
    exit(1);
}
