<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once($autoloadPath);
    if (class_exists('Dotenv\Dotenv')) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad();
    }
}

$timezone         = $_ENV['TZ'] ?? getenv('TZ') ?: 'Europe/Amsterdam';
if (!@date_default_timezone_set($timezone)) {
    date_default_timezone_set('Europe/Amsterdam');
}

$servername       = $_ENV['MARIADB_HOST'] ?? getenv('MARIADB_HOST') ?: '127.0.0.1';
$username         = $_ENV['MARIADB_USER'] ?? getenv('MARIADB_USER') ?: 'qdvr';
$password         = $_ENV['MARIADB_PASSWORD'] ?? getenv('MARIADB_PASSWORD') ?: 'changeme';
$database         = $_ENV['MARIADB_DATABASE'] ?? getenv('MARIADB_DATABASE') ?: 'qdvrdb';
$organization     = $_ENV['ORGANIZATION'] ?? getenv('ORGANIZATION') ?: 'QDVisitorReception';
$logo             = $_ENV['LOGO'] ?? getenv('LOGO') ?: 'northernpetrol';
$privacymail      = $_ENV['PRIVACYMAIL'] ?? getenv('PRIVACYMAIL') ?: 'privacy@northernpetrol.example';
$employee_pincode = $_ENV['EMPLOYEE_PINCODE'] ?? getenv('EMPLOYEE_PINCODE') ?: '1234';
$staffpin         = $employee_pincode;
$retention_days   = (int)($_ENV['RETENTION_DAYS'] ?? getenv('RETENTION_DAYS') ?: 2);

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $dbconnection = new mysqli($servername, $username, $password, $database);
    $dbconnection->set_charset("utf8mb4");

    // Synchronize MariaDB session timezone with configured PHP timezone offset
    $currentTz = new DateTimeZone(date_default_timezone_get());
    $offset = (new DateTime('now', $currentTz))->format('P');
    $dbconnection->query("SET time_zone = '" . $dbconnection->real_escape_string($offset) . "'");
} catch (Throwable $e) {
    die("<div style='font-family:-apple-system,BlinkMacSystemFont,sans-serif;padding:30px;text-align:center;background:#fff;border-radius:12px;max-width:500px;margin:50px auto;box-shadow:0 4px 12px rgba(0,0,0,0.1);'>
        <span style='font-size:72px;'>🙀</span><br><br>
        <h2 style='color:#e53e3e;margin:0 0 10px;'>Database Connection Failed</h2>
        <p style='color:#4a5568;'>Could not connect to database host <code>" . htmlspecialchars($servername, ENT_QUOTES, 'UTF-8') . "</code>.</p>
        <p style='color:#718096;font-size:14px;'>Waiting for MariaDB container to finish initializing... (please refresh in a few seconds)</p>
    </div>");
}

if (!function_exists('e')) {
    function e(?string $str): string {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('get_csrf_token')) {
    function get_csrf_token(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('verify_csrf_token')) {
    function verify_csrf_token(?string $token): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($token) || empty($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
?>
