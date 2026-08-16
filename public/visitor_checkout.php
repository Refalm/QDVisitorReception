<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/back.php");
require_once(__DIR__ . "/sub/taal.php");

$mysqltime = date("Y-m-d H:i:s");
$status = 'error';
$visitorname = '';

if (isset($_GET['id']) || isset($_GET['visitorname'])) {
    if (!empty($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $dbconnection->prepare("SELECT visitorname FROM visitor WHERE id = ? AND departtime IS NULL");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_object()) {
                $visitorname = $row->visitorname;
                $updateStmt = $dbconnection->prepare("UPDATE visitor SET departtime = ? WHERE id = ?");
                if ($updateStmt) {
                    $updateStmt->bind_param("si", $mysqltime, $id);
                    if ($updateStmt->execute()) {
                        $status = 'success';
                    }
                    $updateStmt->close();
                }
            }
            $stmt->close();
        }
    } elseif (!empty($_GET['visitorname'])) {
        $vName = (string)$_GET['visitorname'];
        $stmt = $dbconnection->prepare("UPDATE visitor SET departtime = ? WHERE visitorname = ? AND departtime IS NULL");
        if ($stmt) {
            $stmt->bind_param("ss", $mysqltime, $vName);
            if ($stmt->execute() && $stmt->affected_rows > 0) {
                $status = 'success';
                $visitorname = $vName;
            }
            $stmt->close();
        }
    }
} else {
    header("Location: index.php");
    exit;
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
        <span class="welcome-badge-icon">😸</span>
        <div class="tekst_header"><?php echo e($taal['VISITOROUT_CHECKEDOUT'] ?? 'You have been checked out'); ?>, <?php echo e($visitorname); ?>!</div>
        <p style="font-size:18px;margin-top:10px;opacity:0.9;"><?php echo e($taal['VISITOROUT_THX'] ?? 'Thanks for stopping by.'); ?></p>
        <div class="countdown-bar"><div class="countdown-progress"></div></div>
        <a href="./index.php" class="done-btn">✓ <?php echo e($taal['Done'] ?? 'Done'); ?></a>
    </div>
</body>
<?php else: ?>
<body id="error">
    <div class="result-box">
        <span class="welcome-badge-icon">🙀</span>
        <div class="tekst_header"><?php echo e($taal['DBERROR'] ?? 'An error occurred during checkout.'); ?></div>
        <br><br>
        <a href="./visitor_out.php" class="done-btn">⬅️ <?php echo e($taal['Back'] ?? 'Back'); ?></a>
    </div>
</body>
<?php endif; ?>
</html>
