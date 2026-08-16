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
<meta name="theme-color" content="#0f172a">
</head>
<body id="landing">

<div class="kiosk-header">
    <div class="kiosk-clock" id="kiosk-clock">
        <span class="time" id="clock-time">--:--</span>
        <span id="clock-date">--------</span>
    </div>

    <div class="lang-selector">
        <a href="./?taal=en" class="lang-btn <?php echo ($currentLang === 'en') ? 'active' : ''; ?>">🇬🇧 EN</a>
        <a href="./?taal=nl" class="lang-btn <?php echo ($currentLang === 'nl') ? 'active' : ''; ?>">🇳🇱 NL</a>
        <a href="./?taal=fy" class="lang-btn <?php echo ($currentLang === 'fy') ? 'active' : ''; ?>">🏁 FY</a>
        <a href="./?taal=ie" class="lang-btn <?php echo ($currentLang === 'ie') ? 'active' : ''; ?>">🇮🇪 IE</a>
    </div>
</div>

<div class="landing-container">
    <a href="./employee.php" class="nodecoration">
        <button class="big" type="button">
            <span class="bigfont">👨🏼‍💻</span>
            <span class="tekst"><?php echo e($taal['Employee'] ?? 'Employee'); ?></span>
        </button>
    </a>

    <a href="./visitor_land.php" class="nodecoration">
        <button class="big" type="button">
            <span class="bigfont">🚶🏼‍</span>
            <span class="tekst"><?php echo e($taal['Visitor'] ?? 'Visitor'); ?></span>
        </button>
    </a>
</div>

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
