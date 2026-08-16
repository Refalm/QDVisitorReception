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

function render_lang_switcher(): string
{
    global $selectedLang;
    $languages = [
        'nl' => 'NL',
        'en' => 'EN',
        'fy' => 'FY',
        'ie' => 'IE'
    ];
    $html = '<div class="lang-selector linked-buttons" role="group" aria-label="Language">';
    foreach ($languages as $code => $label) {
        $activeClass = ($selectedLang === $code) ? ' active' : '';
        $html .= '<a href="?taal=' . urlencode($code) . '" class="lang-btn' . $activeClass . '" title="' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</a>';
    }
    $html .= '</div>';
    return $html;
}
