<?php
require_once(__DIR__ . '/../../configuration.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (verify_csrf_token($_POST['csrf_token'] ?? null)) {
        if (!empty($_POST['visitor_id'])) {
            $visitorId = (int)$_POST['visitor_id'];
            $stmt = $dbconnection->prepare("DELETE FROM visitor WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $visitorId);
                $stmt->execute();
                $stmt->close();
            }
        } elseif (!empty($_POST['employee_id'])) {
            $employeeId = (int)$_POST['employee_id'];
            $stmt = $dbconnection->prepare("DELETE FROM employee WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $employeeId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

header("Location: index.php");
exit;
