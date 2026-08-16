<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['taal'])) {
    $taalCode = (string)$_GET['taal'];
    if (in_array($taalCode, ['en', 'nl', 'fy', 'ie'], true)) {
        $_SESSION['taal'] = $taalCode;
        setcookie('taal', $taalCode, [
            'expires' => time() + (3600 * 24 * 30),
            'path' => '/',
            'samesite' => 'Lax',
            'httponly' => false
        ]);
    }
}

$selectedLang = $_SESSION['taal'] ?? $_COOKIE['taal'] ?? 'en';
if (!in_array($selectedLang, ['en', 'nl', 'fy', 'ie'], true)) {
    $selectedLang = 'en';
}

$taalFile = __DIR__ . '/../taal/' . $selectedLang . '.php';
$taal = [];
if (file_exists($taalFile)) {
    include $taalFile;
} else {
    include __DIR__ . '/../taal/en.php';
}
