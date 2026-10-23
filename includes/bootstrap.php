<?php
declare(strict_types=1);

$isSecure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
session_set_cookie_params(['httponly' => true, 'secure' => $isSecure, 'samesite' => 'Lax', 'path' => '/']);
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/validation.php';
require_once __DIR__ . '/csrf.php';

if (isset($_SESSION['user'])) {
    $lastActivity = (int)($_SESSION['last_activity'] ?? time());
    if (time() - $lastActivity > 1800) {
        unset($_SESSION['user'], $_SESSION['last_activity']);
        flash('info', 'Your session expired after inactivity. Please sign in again.');
    } else {
        $_SESSION['last_activity'] = time();
    }
}

function db_or_error(): ?PDO
{
    try { return database(); }
    catch (Throwable $error) {
        error_log('COVID site database connection failed: ' . $error->getMessage());
        return null;
    }
}
