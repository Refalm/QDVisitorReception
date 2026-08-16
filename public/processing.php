<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/back.php");
require_once(__DIR__ . "/sub/taal.php");

$mysqltime = date("Y-m-d H:i:s");
$status = 'error';
$statusMessage = '';
$visitorname = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        $status = 'error';
        $statusMessage = 'Invalid security token. Please try again.';
    } elseif (!empty($_POST['visitorname']) && !empty($_POST['visitormail']) && !empty($_POST['visitororg'])) {
        $visitorname = trim((string)$_POST['visitorname']);
        $visitormail = trim((string)$_POST['visitormail']);
        $visitororg  = trim((string)$_POST['visitororg']);
        $visitorhost = trim((string)($_POST['visitorhost'] ?? ''));

        // Check if this visitor is currently already registered and not departed
        $checkStmt = $dbconnection->prepare("SELECT id FROM visitor WHERE visitorname = ? AND departtime IS NULL LIMIT 1");
        if ($checkStmt) {
            $checkStmt->bind_param("s", $visitorname);
            $checkStmt->execute();
            $checkRes = $checkStmt->get_result();
            $alreadyInside = ($checkRes && $checkRes->num_rows > 0);
            $checkStmt->close();

            if ($alreadyInside) {
                $status = 'already_inside';
            } else {
                $insertStmt = $dbconnection->prepare("INSERT INTO visitor (visitorname, visitormail, visitororg, visitorhost, arrivetime, departtime) VALUES (?, ?, ?, ?, ?, NULL)");
                if ($insertStmt) {
                    $insertStmt->bind_param("sssss", $visitorname, $visitormail, $visitororg, $visitorhost, $mysqltime);
                    if ($insertStmt->execute()) {
                        $status = 'success';
                    } else {
                        $status = 'error';
                        $statusMessage = $dbconnection->error;
                    }
                    $insertStmt->close();
                } else {
                    $status = 'error';
                    $statusMessage = $dbconnection->error;
                }
            }
        }
    }
}
?><!DOCTYPE html>
<html lang="<?php echo e($_SESSION['taal'] ?? 'en'); ?>">
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
<link rel="stylesheet" href="./style.css" />
<meta http-equiv="refresh" content="5; URL=./index.php" />
</head>
<?php if ($status === 'success'): ?>
<body id="success">
    <div class="result-box">
        <span class="bigfont">😺</span>
        <br /><br />
        <div class="tekst_header"><?php echo e($taal['VISITORPROC_YEE'] ?? 'Welcome!'); ?>, <?php echo e($visitorname); ?>!</div>
        <div class="countdown-bar"><div class="countdown-progress"></div></div>
        <a href="./index.php" class="done-btn">✓ <?php echo e($taal['Done'] ?? 'Done'); ?></a>
    </div>
</body>
<?php elseif ($status === 'already_inside'): ?>
<body id="landing">
    <div class="result-box">
        <span class="bigfont">😼</span>
        <br /><br />
        <div class="tekst_header"><?php echo $taal['VISITORPROC_WUT'] ?? 'You are probably already registered.'; ?></div>
        <div class="countdown-bar"><div class="countdown-progress"></div></div>
        <a href="./index.php" class="done-btn">✓ <?php echo e($taal['Done'] ?? 'Done'); ?></a>
    </div>
</body>
<?php else: ?>
<body id="error">
    <div class="result-box">
        <span class="bigfont">🙀</span>
        <br /><br />
        <div class="tekst_header"><?php echo e($taal['DBERROR'] ?? 'An error occurred.'); ?></div>
        <?php if (!empty($statusMessage)): ?>
            <br /><span class="tekst_code"><?php echo e($statusMessage); ?></span>
        <?php endif; ?>
        <br><br>
        <a href="./visitor_inn.php" class="done-btn">⬅️ <?php echo e($taal['Back'] ?? 'Back'); ?></a>
    </div>
</body>
<?php endif; ?>
</html>
