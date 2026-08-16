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
<style>
    * { box-sizing: border-box; }
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background: #f4f6f8;
        color: #222;
        margin: 0;
        padding: 24px;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }
    h1 {
        color: #1a202c;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 8px;
        margin-top: 32px;
    }
    .card {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 30px;
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th, td {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #edf2f7;
    }
    th {
        background: #f7fafc;
        font-weight: 600;
        color: #4a5568;
    }
    tr:hover {
        background: #f8fafc;
    }
    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
    }
    .badge-present {
        background: #c6f6d5;
        color: #22543d;
    }
    .badge-departed {
        background: #edf2f7;
        color: #4a5568;
    }
    .btn-delete {
        background: #fff5f5;
        border: 1px solid #fed7d7;
        color: #e53e3e;
        border-radius: 4px;
        padding: 6px 10px;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-delete:hover {
        background: #feb2b2;
    }
    .form-group {
        margin-bottom: 16px;
    }
    .input-text {
        padding: 10px 14px;
        font-size: 16px;
        border: 1px solid #cbd5e0;
        border-radius: 4px;
        width: 100%;
        max-width: 400px;
    }
    .btn-primary {
        background: #3182ce;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-primary:hover {
        background: #2b6cb0;
    }
    .alert {
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    .alert-success { background: #c6f6d5; color: #22543d; }
    .alert-warning { background: #feebc8; color: #7b341e; }
    .alert-error { background: #fed7d7; color: #742a2a; }
    .back-nav {
        margin-top: 30px;
    }
    .btn-back {
        background: #4a5568;
        color: #fff;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #a0aec0;
    }
</style>
</head>
<body>
<div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h2>QDVisitorReception - Reception Desk</h2>
        <a href="../" class="btn-back">⬅️ Back to Kiosk</a>
    </div>

    <?php if ($notice): ?>
        <div class="alert alert-<?php echo e($notice['type']); ?>">
            <?php echo e($notice['message']); ?>
        </div>
    <?php endif; ?>

    <h1>Visitors</h1>
    <div class="card">
        <?php if (!empty($visitors)): ?>
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
                                    <span class="badge badge-present">🟢 Active (Present)</span>
                                <?php else: ?>
                                    <span class="badge badge-departed"><?php echo e($v->departtime); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="post" action="delete.php" onsubmit="return confirm('Delete visitor <?php echo e(addslashes($v->visitorname)); ?>?');" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo e(get_csrf_token()); ?>" />
                                    <input type="hidden" name="visitor_id" value="<?php echo (int)$v->id; ?>" />
                                    <button type="submit" class="btn-delete">❌ Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <span style="font-size:48px;">🗇</span><br><br>No visitor records found.
            </div>
        <?php endif; ?>
    </div>

    <h1>Employees</h1>
    <div class="card">
        <?php if (!empty($employees)): ?>
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
                                    <span class="badge badge-present">🔳 Present</span>
                                <?php else: ?>
                                    <span class="badge badge-departed">🔲 Away</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="post" action="delete.php" onsubmit="return confirm('Remove employee <?php echo e(addslashes($emp->name)); ?>?');" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo e(get_csrf_token()); ?>" />
                                    <input type="hidden" name="employee_id" value="<?php echo (int)$emp->id; ?>" />
                                    <button type="submit" class="btn-delete">❌ Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <span style="font-size:48px;">🗇</span><br><br>The employee list is empty.
            </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3>Add New Employee</h3>
        <form method="post" action="./index.php">
            <input type="hidden" name="csrf_token" value="<?php echo e(get_csrf_token()); ?>" />
            <input type="hidden" name="add_employee" value="1" />
            <div class="form-group">
                <label for="employeename" style="display:block;margin-bottom:8px;font-weight:600;">Employee Name</label>
                <input id="employeename" name="employeename" type="text" placeholder="e.g. Henk de Vries" required class="input-text" />
            </div>
            <button type="submit" class="btn-primary">🖋 Add Employee</button>
        </form>
    </div>

    <div class="back-nav">
        <a href="../" class="btn-back">⬅️ Back to Kiosk</a>
    </div>
</div>
</body>
</html>
