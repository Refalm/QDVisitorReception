<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/back.php");
require_once(__DIR__ . "/sub/taal.php");
?><!DOCTYPE html>
<html lang="<?php echo e($_SESSION['taal'] ?? 'en'); ?>">
<head>
<title>QDVisitorReception - <?php echo e($taal['Visitor'] ?? 'Visitor'); ?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
<link rel="stylesheet" href="./style.css" />
<script src="./kiosk.js" defer></script>
</head>
<body id="landing">

<header class="headerbar">
    <div class="headerbar-left">
        <a href="./index.php" class="back-btn">
            <span>⬅️</span>
            <span><?php echo e($taal['Back'] ?? 'Back'); ?></span>
        </a>
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
    <h1 class="welcome-title"><?php echo e($taal['VISITORIN_TITLE'] ?? 'Visitor Reception'); ?></h1>
    <p class="welcome-subtitle"><?php echo e($taal['INFO_VISITOROUT_PRESS'] ?? 'Please select an option to check in or out'); ?></p>

    <div class="welcome-tiles-grid">
        <a href="./visitor_in.php" class="welcome-tile suggested">
            <div class="welcome-tile-icon">🏢🚶🏼</div>
            <div class="welcome-tile-title"><?php echo e($taal['Entering'] ?? 'Check In'); ?></div>
            <div class="welcome-tile-desc"><?php echo e($taal['Step_1'] ?? 'Register your visit'); ?></div>
        </a>

        <a href="./visitor_out.php" class="welcome-tile">
            <div class="welcome-tile-icon">🚪🚶🏼</div>
            <div class="welcome-tile-title"><?php echo e($taal['Leaving'] ?? 'Check Out'); ?></div>
            <div class="welcome-tile-desc"><?php echo e($taal['Search_for_your_name'] ?? 'Sign out before leaving'); ?></div>
        </a>
    </div>
</main>

<?php include __DIR__ . '/sub/logo.php'; ?>

</body>
</html>
