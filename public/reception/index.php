<?php
require_once(__DIR__ . '/../../configuration.php');

$notice = null;

// Handle new employee addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_employee'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        $notice = ['type' => 'error', 'message' => 'Invalid security token.'];
    } else {
        $employeeName = trim((string)($_POST['employeename'] ?? ''));
        if ($employeeName !== '') {
            $checkStmt = $dbconnection->prepare("SELECT id FROM employee WHERE name = ? LIMIT 1");
            if ($checkStmt) {
                $checkStmt->bind_param("s", $employeeName);
                $checkStmt->execute();
                $res = $checkStmt->get_result();
                if ($res && $res->num_rows > 0) {
                    $notice = ['type' => 'warning', 'message' => "$employeeName is already on the employee list."];
                } else {
                    $insStmt = $dbconnection->prepare("INSERT INTO employee (name, present) VALUES (?, 0)");
                    if ($insStmt) {
                        $insStmt->bind_param("s", $employeeName);
                        if ($insStmt->execute()) {
                            $notice = ['type' => 'success', 'message' => "$employeeName added to employees."];
                        }
                        $insStmt->close();
                    }
                }
                $checkStmt->close();
            }
        }
    }
}

// Fetch visitors
$visitors = [];
if ($res = $dbconnection->query("SELECT id, visitorname, visitormail, visitororg, visitorhost, arrivetime, departtime FROM visitor ORDER BY arrivetime DESC LIMIT 200")) {
    while ($row = $res->fetch_object()) {
        $visitors[] = $row;
    }
    $res->close();
}

// Fetch employees
$employees = [];
if ($res = $dbconnection->query("SELECT id, name, present FROM employee ORDER BY name ASC")) {
    while ($row = $res->fetch_object()) {
        $employees[] = $row;
    }
    $res->close();
}
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Reception Administration - QDVisitorReception</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
<link rel="stylesheet" href="../style.css" />
<style>
    body {
        padding: 0;
        background: var(--bg-context);
    }
    .reception-container {
        max-width: 1160px;
        margin: 28px auto 60px auto;
        padding: 0 20px;
    }
    .table-container {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
    }
    th, td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }
    th {
        background: var(--color-silver-100);
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
    }
    tr:hover {
        background: #f8fafc;
    }
    .badge-present {
        background: rgba(40, 188, 163, 0.15);
        color: var(--color-mint-900);
        border: 1px solid var(--color-mint-500);
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }
    .badge-departed {
        background: var(--color-silver-100);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }
    .btn-delete-row {
        background: var(--danger-bg);
        border: 1px solid var(--color-strawberry-100);
        color: var(--danger);
        border-radius: var(--radius-entry);
        padding: 6px 12px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        font-family: inherit;
        transition: all 0.15s ease;
    }
    .btn-delete-row:hover {
        background: var(--danger);
        color: #ffffff;
    }
    .alert-box {
        padding: 14px 18px;
        border-radius: var(--radius-entry);
        margin-bottom: 24px;
        font-weight: 600;
        font-size: 15px;
    }
    .alert-box.alert-success {
        background: rgba(40, 188, 163, 0.15);
        color: var(--color-mint-900);
        border: 1px solid var(--color-mint-500);
    }
    .alert-box.alert-warning {
        background: rgba(249, 196, 64, 0.2);
        color: var(--color-banana-900);
        border: 1px solid #ffe16b;
    }
    .alert-box.alert-error {
        background: var(--danger-bg);
        color: var(--color-strawberry-900);
        border: 1px solid var(--color-strawberry-100);
    }
    .empty-state-box {
        text-align: center;
        padding: 48px 20px;
        color: var(--text-muted);
        font-size: 17px;
    }
</style>
</head>
<body id="context">

<header class="headerbar">
    <div class="headerbar-left">
        <span class="headerbar-title">QDVisitorReception — Reception Desk</span>
    </div>
    <div class="headerbar-right">
        <a href="../" class="back-btn">
            <span>⬅️</span>
            <span>Back to Kiosk</span>
        </a>
    </div>
</header>

<div class="reception-container">
    <?php if ($notice): ?>
        <div class="alert-box alert-<?php echo e($notice['type']); ?>">
            <?php echo e($notice['message']); ?>
        </div>
    <?php endif; ?>

    <h1>Active & Past Visitors</h1>
    <div class="card">
        <?php if (!empty($visitors)): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Organization</th>
                            <th>Host</th>
                            <th>Arrived</th>
                            <th>Status / Departed</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($visitors as $v): ?>
                            <tr>
                                <td><strong><?php echo e($v->visitorname); ?></strong></td>
                                <td><?php echo e($v->visitormail); ?></td>
                                <td><?php echo e($v->visitororg); ?></td>
                                <td><?php echo e($v->visitorhost); ?></td>
                                <td><?php echo e($v->arrivetime); ?></td>
                                <td>
                                    <?php if ($v->departtime === null || $v->departtime === '2038-01-19 03:14:07'): ?>
                                        <span class="badge-present">🟢 Active (Present)</span>
                                    <?php else: ?>
                                        <span class="badge-departed"><?php echo e($v->departtime); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="post" action="delete.php" onsubmit="return confirm('Delete visitor record <?php echo e(addslashes($v->visitorname)); ?>?');" style="display:inline;">
                                        <input type="hidden" name="csrf_token" value="<?php echo e(get_csrf_token()); ?>" />
                                        <input type="hidden" name="visitor_id" value="<?php echo (int)$v->id; ?>" />
                                        <button type="submit" class="btn-delete-row">❌ Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state-box">
                <span style="font-size:48px;">🗇</span><br><br>No visitor records found.
            </div>
        <?php endif; ?>
    </div>

    <h1>Employees & Staff List</h1>
    <div class="card">
        <?php if (!empty($employees)): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Presence Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $emp): ?>
                            <tr>
                                <td><strong><?php echo e($emp->name); ?></strong></td>
                                <td>
                                    <?php if ($emp->present): ?>
                                        <span class="badge-present">🔳 Present</span>
                                    <?php else: ?>
                                        <span class="badge-departed">🔲 Away</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="post" action="delete.php" onsubmit="return confirm('Remove employee <?php echo e(addslashes($emp->name)); ?>?');" style="display:inline;">
                                        <input type="hidden" name="csrf_token" value="<?php echo e(get_csrf_token()); ?>" />
                                        <input type="hidden" name="employee_id" value="<?php echo (int)$emp->id; ?>" />
                                        <button type="submit" class="btn-delete-row">❌ Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state-box">
                <span style="font-size:48px;">🗇</span><br><br>The employee list is empty.
            </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <h2>Add New Employee</h2>
        <form method="post" action="./index.php">
            <input type="hidden" name="csrf_token" value="<?php echo e(get_csrf_token()); ?>" />
            <input type="hidden" name="add_employee" value="1" />
            <div class="form-group">
                <label for="employeename">Employee Full Name</label>
                <input id="employeename" name="employeename" type="text" placeholder="e.g. Henk de Vries" required class="entry" style="max-width:400px;" />
            </div>
            <button type="submit" class="button suggested-action" style="width:auto;height:48px;font-size:16px;">
                <span>🖋 Add Employee</span>
            </button>
        </form>
    </div>
</div>
</body>
</html>
