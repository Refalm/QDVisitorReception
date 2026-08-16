<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/back.php");
require_once(__DIR__ . "/sub/taal.php");

// Fetch employees for autocomplete datalist
$employees = [];
if ($res = $dbconnection->query("SELECT name FROM employee ORDER BY name ASC")) {
    while ($emp = $res->fetch_object()) {
        $employees[] = $emp->name;
    }
    $res->close();
}
?><!DOCTYPE html>
<html lang="<?php echo e($_SESSION['taal'] ?? 'en'); ?>">
<head>
<title>QDVisitorReception - <?php echo e($taal['Visitor'] ?? 'Visitor Details'); ?></title>
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
        <a href="./visitor_in.php" class="back-btn">
            <span>⬅️</span>
            <span><?php echo e($taal['Back'] ?? 'Back'); ?></span>
        </a>
    </div>
    <div class="headerbar-center">
        <span class="headerbar-title"><?php echo e($taal['Visitor'] ?? 'Visitor Details'); ?></span>
    </div>
    <div class="headerbar-right">
        <?php echo render_lang_switcher(); ?>
    </div>
</header>

<main class="content-wrapper">
    <div class="card">
        <div class="step-header">
            <h1><?php echo e($taal['Visitor'] ?? 'Your Information'); ?></h1>
            <span class="step-badge"><?php echo e($taal['Step_2'] ?? 'Step 2 of 2'); ?></span>
        </div>

        <form id="bezoeker" method="post" action="processing.php" onsubmit="document.getElementById('submit-btn').disabled = true; document.getElementById('submit-btn').innerHTML = '⏳ <?php echo e(addslashes($taal['Saving'] ?? 'Saving...')); ?>';">
            <input type="hidden" name="csrf_token" value="<?php echo e(get_csrf_token()); ?>" />
            
            <div class="form-group">
                <label for="visitorname"><?php echo e($taal['Name'] ?? 'Forename and Surname'); ?></label>
                <input id="visitorname" name="visitorname" type="text" placeholder="e.g. Gabe Newell" required class="entry" autocomplete="name" autocapitalize="words" autofocus />
            </div>
            
            <div class="form-group">
                <label for="visitormail"><?php echo e($taal['E-mail_address'] ?? 'E-mail Address'); ?></label>
                <input id="visitormail" name="visitormail" type="email" placeholder="e.g. gaben@valvesoftware.com" required class="entry" autocomplete="email" inputmode="email" />
            </div>
            
            <div class="form-group">
                <label for="visitororg"><?php echo e($taal['Organization'] ?? 'Organization / Company'); ?></label>
                <input id="visitororg" name="visitororg" type="text" placeholder="e.g. Valve Corporation" required class="entry" autocomplete="organization" autocapitalize="words" />
            </div>
            
            <div class="form-group">
                <label for="visitorhost"><?php echo e($taal['NAME_EMPLOYEE4VISIT'] ?? 'Host (Person You Are Visiting)'); ?></label>
                <input id="visitorhost" name="visitorhost" type="text" list="employee-list" placeholder="e.g. Henk de Vries" required class="entry" autocomplete="off" autocapitalize="words" />
                <datalist id="employee-list">
                    <?php foreach ($employees as $empName): ?>
                        <option value="<?php echo e($empName); ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
            
            <button type="submit" id="submit-btn" class="button suggested-action">
                <span>🖋 <?php echo e($taal['INPUT'] ?? 'Complete Registration'); ?></span>
            </button>
        </form>
    </div>
</main>

<?php include __DIR__ . '/sub/logo.php'; ?>

</body>
</html>
