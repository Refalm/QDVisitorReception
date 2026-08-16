<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/taal.php");

// <Delete expired visitor entries after retention days>
$days = max(1, $retention_days);
$stmt = $dbconnection->prepare("DELETE FROM visitor WHERE departtime IS NOT NULL AND departtime <= NOW() - INTERVAL ? DAY");
if ($stmt) {
    $stmt->bind_param("i", $days);
    $stmt->execute();
    $stmt->close();
}
// </Delete expired visitor entries>

$currentLang = $_SESSION['taal'] ?? $_COOKIE['taal'] ?? 'en';
?><!DOCTYPE html>
<html lang="<?php echo e($currentLang); ?>">
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="QDVisitorRegistration">
<meta name="application-name" content="QDVisitorRegistration">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
<link rel="stylesheet" href="./style.css">
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<link rel="manifest" href="favicon/manifest.json">
<meta name="theme-color" content="#273445">
<script src="./kiosk.js" defer></script>
</head>
<body id="landing">

<header class="headerbar">
    <div class="headerbar-left">
        <div class="headerbar-clock">
            <span>🕒</span>
            <span class="time" id="clock-time">--:--</span>
            <span id="clock-date" style="opacity:0.8;"></span>
        </div>
    </div>
    <div class="headerbar-center">
        <span class="headerbar-title"><?php echo e($organization); ?></span>
    </div>
    <div class="headerbar-right">
        <?php echo render_lang_switcher(); ?>
    </div>
</header>

<main class="welcome-view">
    <div class="welcome-badge-icon">🏢</div>
    <h1 class="welcome-title"><?php echo e($organization); ?></h1>
    <p class="welcome-subtitle"><?php echo e($taal['VISITORIN_TITLE'] ?? 'Welcome to Visitor Reception'); ?></p>

    <div class="welcome-tiles-grid">
        <a href="./visitor_land.php" class="welcome-tile suggested" title="<?php echo e($taal['Visitor'] ?? 'Visitor'); ?>">
            <div class="welcome-tile-icon">🚶🏼‍</div>
            <div class="welcome-tile-title"><?php echo e($taal['Visitor'] ?? 'Visitor'); ?></div>
            <div class="welcome-tile-desc"><?php echo e($taal['Entering'] ?? 'Check In / Out'); ?></div>
        </a>

        <a href="./employee.php" class="welcome-tile" title="<?php echo e($taal['Employee'] ?? 'Employee'); ?>">
            <div class="welcome-tile-icon">👨🏼‍💻</div>
            <div class="welcome-tile-title"><?php echo e($taal['Employee'] ?? 'Employee'); ?></div>
            <div class="welcome-tile-desc"><?php echo e($taal['Employees_present'] ?? 'Staff Access & Presence'); ?></div>
        </a>
    </div>
</main>

<?php include __DIR__ . '/sub/logo.php'; ?>

<script>
function updateClock() {
    const now = new Date();
    const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const dateStr = now.toLocaleDateString('<?php echo ($currentLang === "nl" ? "nl-NL" : ($currentLang === "fy" ? "fy-NL" : "en-US")); ?>', { weekday: 'short', month: 'short', day: 'numeric' });
    document.getElementById('clock-time').textContent = timeStr;
    document.getElementById('clock-date').textContent = '• ' + dateStr;
}
updateClock();
setInterval(updateClock, 1000);
</script>

</body>
</html>
