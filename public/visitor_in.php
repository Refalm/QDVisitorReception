<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/back.php");
require_once(__DIR__ . "/sub/taal.php");
?><!DOCTYPE html>
<html lang="<?php echo e($_SESSION['taal'] ?? 'en'); ?>">
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
<link rel="stylesheet" href="./style.css" />
<script src="./kiosk.js" defer></script>
</head>
<body id="context">
<?php include __DIR__ . '/sub/logo.php'; ?>

<div class="content-wrapper">
    <div class="card">
        <div class="step-header">
            <h1><?php echo e($taal['VISITORIN_TITLE'] ?? 'Visitor registration'); ?></h1>
            <span class="step-badge"><?php echo e($taal['Step_1'] ?? 'Step 1 of 2'); ?></span>
        </div>

        <div class="handling-notice">
            <?php echo $taal['VISITORIN_HANDLING'] ?? ''; ?>
        </div>

        <h2><?php echo e($taal['VISITORIN_RULESTITLE'] ?? 'Rules for visitors'); ?></h2>
        
        <div class="rules-list">
            <div class="rule-item">
                <span class="rule-icon">📷</span>
                <span><?php echo e($taal['VISITORIN_RULESCAM'] ?? ''); ?></span>
            </div>
            <div class="rule-item">
                <span class="rule-icon">⚡</span>
                <span><?php echo e($taal['VISITORIN_RULESESD'] ?? ''); ?></span>
            </div>
            <div class="rule-item">
                <span class="rule-icon">🚶🏼</span>
                <span><?php echo e($taal['VISITORIN_RULESPPL'] ?? ''); ?></span>
            </div>
        </div>

        <a href="./visitor_inn.php" class="nodecoration">
            <button class="accept" type="button">
                <span>✅ <?php echo e($taal['Accept'] ?? 'Accept'); ?></span>
            </button>
        </a>
    </div>
</div>

<?php echo backurl("./visitor_land.php"); ?>

</body>
</html>
