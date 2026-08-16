<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/back.php");
require_once(__DIR__ . "/sub/taal.php");
?><!DOCTYPE html>
<html lang="<?php echo e($_SESSION['taal'] ?? 'en'); ?>">
<head>
<title>QDVisitorReception - <?php echo e($taal['VISITORIN_TITLE'] ?? 'Visitor Registration'); ?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
<link rel="stylesheet" href="./style.css" />
<script src="./kiosk.js" defer></script>
</head>
<body id="context">

<header class="headerbar">
    <div class="headerbar-left">
        <a href="./visitor_land.php" class="back-btn">
            <span>⬅️</span>
            <span><?php echo e($taal['Back'] ?? 'Back'); ?></span>
        </a>
    </div>
    <div class="headerbar-center">
        <span class="headerbar-title"><?php echo e($taal['VISITORIN_TITLE'] ?? 'Visitor Registration'); ?></span>
    </div>
    <div class="headerbar-right">
        <?php echo render_lang_switcher(); ?>
    </div>
</header>

<main class="content-wrapper">
    <div class="card">
        <div class="step-header">
            <h1><?php echo e($taal['VISITORIN_RULESTITLE'] ?? 'Rules for Visitors'); ?></h1>
            <span class="step-badge"><?php echo e($taal['Step_1'] ?? 'Step 1 of 2'); ?></span>
        </div>

        <div class="handling-notice">
            <?php echo $taal['VISITORIN_HANDLING'] ?? ''; ?>
        </div>

        <div class="rules-list">
            <div class="rule-item">
                <span class="rule-icon">📷</span>
                <span><?php echo e($taal['VISITORIN_RULESCAM'] ?? 'No unauthorized photo, video or audio recording.'); ?></span>
            </div>
            <div class="rule-item">
                <span class="rule-icon">⚡</span>
                <span><?php echo e($taal['VISITORIN_RULESESD'] ?? 'Follow instructions when entering ESD-safe zones.'); ?></span>
            </div>
            <div class="rule-item">
                <span class="rule-icon">🚶🏼</span>
                <span><?php echo e($taal['VISITORIN_RULESPPL'] ?? 'Visitors must be accompanied by their host at all times.'); ?></span>
            </div>
        </div>

        <a href="./visitor_inn.php" class="nodecoration">
            <button class="button success-action" type="button">
                <span>✅ <?php echo e($taal['Accept'] ?? 'Accept & Continue'); ?></span>
            </button>
        </a>
    </div>
</main>

<?php include __DIR__ . '/sub/logo.php'; ?>

</body>
</html>
