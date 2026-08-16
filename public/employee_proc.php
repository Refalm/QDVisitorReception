<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/back.php");
require_once(__DIR__ . "/sub/taal.php");

// Verify auth
if (empty($_SESSION['authenticated']) || empty($_SESSION['authenticated_time']) || (time() - $_SESSION['authenticated_time'] > 180)) {
    unset($_SESSION['authenticated']);
    unset($_SESSION['authenticated_time']);
    header("Location: employee.php");
    exit;
}
$_SESSION['authenticated_time'] = time();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        header("Location: employee.php");
        exit;
    }

    if (isset($_POST['employee_id']) && isset($_POST['action'])) {
        $empId = (int)$_POST['employee_id'];
        $newPresent = ($_POST['action'] === 'present') ? 1 : 0;
        $stmt = $dbconnection->prepare("UPDATE employee SET present = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("ii", $newPresent, $empId);
            $stmt->execute();
            $stmt->close();
        }
    }

    header("Location: employee.php");
    exit;
} else {
    header("Location: employee.php");
    exit;
}
