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
<body id="landing">

<div class="landing-container">
    <a href="./visitor_in.php" class="nodecoration">
        <button class="big" type="button">
            <span class="bigfont">🏢🚶🏼</span>
            <span class="tekst"><?php echo e($taal['Entering'] ?? 'Entering'); ?></span>
        </button>
    </a>

    <a href="./visitor_out.php" class="nodecoration">
        <button class="big" type="button">
            <span class="bigfont">🚪🚶🏼</span>
            <span class="tekst"><?php echo e($taal['Leaving'] ?? 'Leaving'); ?></span>
        </button>
    </a>
</div>

<?php include __DIR__ . '/sub/logo.php'; ?>
<?php echo backurl("."); ?>

</body>
</html>
