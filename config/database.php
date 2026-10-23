<?php
declare(strict_types=1);

function database(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $localConfigPath = __DIR__ . '/database.local.php';
    $localConfig = is_file($localConfigPath) ? require $localConfigPath : [];
    if (!is_array($localConfig)) $localConfig = [];

    $host = getenv('COVID_DB_HOST') ?: ($localConfig['host'] ?? '127.0.0.1');
    $name = getenv('COVID_DB_NAME') ?: ($localConfig['name'] ?? 'covid_db');
    $user = getenv('COVID_DB_USER') ?: ($localConfig['user'] ?? 'root');
    $pass = getenv('COVID_DB_PASS') ?: ($localConfig['pass'] ?? '');
    $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    return $pdo;
}
