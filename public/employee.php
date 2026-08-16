<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/back.php");
require_once(__DIR__ . "/sub/taal.php");

// Session timeout: 180 seconds (3 minutes)
$sessionTimeout = 180;
if (!empty($_SESSION['authenticated']) && !empty($_SESSION['authenticated_time'])) {
    if (time() - $_SESSION['authenticated_time'] > $sessionTimeout) {
        unset($_SESSION['authenticated']);
        unset($_SESSION['authenticated_time']);
    } else {
        $_SESSION['authenticated_time'] = time();
    }
}

// PIN rate limiting
$now = time();
$lockoutTime = 60; // seconds
if (!isset($_SESSION['pin_attempts'])) {
    $_SESSION['pin_attempts'] = 0;
}
if (!isset($_SESSION['pin_lockout_until'])) {
    $_SESSION['pin_lockout_until'] = 0;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pincode'])) {
    if ($now < $_SESSION['pin_lockout_until']) {
        $remaining = $_SESSION['pin_lockout_until'] - $now;
        $error = sprintf($taal['Please_wait'] ?? '⏳ Please wait %ss...', $remaining);
    } else {
        $submittedPin = (string)$_POST['pincode'];
        if (hash_equals($employee_pincode, $submittedPin)) {
            $_SESSION['authenticated'] = true;
            $_SESSION['authenticated_time'] = time();
            $_SESSION['pin_attempts'] = 0;
            $_SESSION['pin_lockout_until'] = 0;
        } else {
            $_SESSION['pin_attempts']++;
            if ($_SESSION['pin_attempts'] >= 5) {
                $_SESSION['pin_lockout_until'] = $now + $lockoutTime;
                $_SESSION['pin_attempts'] = 0;
                $error = $taal['Too_many_attempts'] ?? '🔒 Too many attempts. Locked for 60s.';
            } else {
                $error = $taal['Invalid_pincode'] ?? '😾 Invalid PIN code';
            }
        }
    }
}

// If not authenticated, show PIN keypad
if (empty($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    ?><!DOCTYPE html>
    <html lang="<?php echo e($_SESSION['taal'] ?? 'en'); ?>">
    <head>
        <title>PIN code - QDVisitorReception</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="./style.css">
        <script src="./kiosk.js" defer></script>
    </head>
    <body id="context">
        <div class="content-wrapper">
            <div class="card numpad-container">
                <h1>PIN code</h1>
                <p style="color:var(--text-muted);font-size:16px;margin:0 0 16px 0;"><?php echo e($taal['Enter_pincode'] ?? 'Enter staff PIN code:'); ?></p>
                <form method="post" action="" id="pin-form">
                    <input type="password" name="pincode" id="pincode" class="hidden-input" required autocomplete="off" />
                    <div id="display"></div>
                    
                    <div class="numpad">
                        <?php for ($i = 1; $i <= 9; $i++): ?>
                            <button type="button" onclick="appendNumber('<?php echo $i; ?>')"><?php echo $i; ?></button>
                        <?php endfor; ?>
                        <button type="button" onclick="clearInput()" title="<?php echo e($taal['Clear'] ?? 'Clear'); ?>">C</button>
                        <button type="button" onclick="appendNumber('0')">0</button>
                        <button type="button" onclick="deleteNumber()" title="Backspace">⌫</button>
                    </div>
                    <?php if ($error !== null): ?>
                        <div id="error-message"><?php echo e($error); ?></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <script>
            function appendNumber(num) {
                const input = document.getElementById('pincode');
                const display = document.getElementById('display');
                if (input.value.length < 8) {
                    input.value += num;
                    display.innerText += '•';
                    if (input.value.length === 4) {
                        setTimeout(() => {
                            if (input.value.length === 4) {
                                document.getElementById('pin-form').submit();
                            }
                        }, 250);
                    }
                }
            }

            function deleteNumber() {
                const input = document.getElementById('pincode');
                const display = document.getElementById('display');
                input.value = input.value.slice(0, -1);
                display.innerText = display.innerText.slice(0, -1);
            }

            function clearInput() {
                const input = document.getElementById('pincode');
                const display = document.getElementById('display');
                input.value = '';
                display.innerText = '';
            }

            window.onload = function() {
                const errorMessage = document.getElementById('error-message');
                if (errorMessage) {
                    setTimeout(() => {
                        errorMessage.style.display = 'none';
                    }, 4000);
                }
            };
        </script>
        <?php echo backurl("."); ?>
    </body>
    </html>
    <?php
    exit;
}

// Authenticated Employee List
$employees = [];
if ($res = $dbconnection->query("SELECT id, name, present FROM employee ORDER BY name ASC")) {
    while ($row = $res->fetch_object()) {
        $employees[] = $row;
    }
    $res->close();
}
?><!DOCTYPE html>
<html lang="<?php echo e($_SESSION['taal'] ?? 'en'); ?>">
<head>
<title>Employees - QDVisitorReception</title>
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
        <h1><?php echo e($taal['Employees_present'] ?? 'Employees present'); ?></h1>
        
        <div class="search-wrapper" style="margin-top:20px;">
            <span class="search-icon">🔍</span>
            <input type="text" id="employee-search" class="search-input" placeholder="<?php echo e($taal['Search_employee'] ?? 'Search employee...'); ?>" oninput="filterEmployees()" autocomplete="off" />
        </div>

        <div class="employee-grid" id="employee-grid">
            <?php if (!empty($employees)): ?>
                <?php foreach ($employees as $emp): ?>
                    <div class="employee-row" data-name="<?php echo e(strtolower($emp->name)); ?>">
                        <span class="employee-name"><?php echo e($emp->name); ?></span>
                        
                        <form method="post" action="employee_proc.php" onsubmit="togglePresence(event, this, <?php echo (int)$emp->id; ?>)">
                            <input type="hidden" name="csrf_token" value="<?php echo e(get_csrf_token()); ?>" />
                            <input type="hidden" name="employee_id" value="<?php echo (int)$emp->id; ?>" />
                            <input type="hidden" name="action" id="action-<?php echo (int)$emp->id; ?>" value="<?php echo $emp->present ? 'away' : 'present'; ?>" />
                            
                            <button type="submit" id="btn-<?php echo (int)$emp->id; ?>" class="presence-btn <?php echo $emp->present ? 'is-present' : 'is-away'; ?>">
                                <?php if ($emp->present): ?>
                                    <span>🔳 <?php echo e($taal['YES'] ?? 'YES'); ?></span>
                                <?php else: ?>
                                    <span>🔲 <?php echo e($taal['NO'] ?? 'NO'); ?></span>
                                <?php endif; ?>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align:center;padding:40px;color:var(--text-muted);font-size:20px;">
                    <span style="font-size:48px;">🗇</span><br><br>
                    <?php echo e($taal['Employee_list_empty'] ?? 'The employee list is empty...'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function filterEmployees() {
    const query = document.getElementById('employee-search').value.toLowerCase().trim();
    const rows = document.querySelectorAll('.employee-row');
    rows.forEach(row => {
        const name = row.getAttribute('data-name');
        row.style.display = name.includes(query) ? 'flex' : 'none';
    });
}

function togglePresence(e, form, empId) {
    if (window.fetch) {
        e.preventDefault();
        const actionInput = document.getElementById('action-' + empId);
        const btn = document.getElementById('btn-' + empId);
        const targetAction = actionInput.value;
        const formData = new FormData(form);

        if (targetAction === 'present') {
            btn.className = 'presence-btn is-present';
            btn.innerHTML = '<span>🔳 <?php echo e($taal['YES'] ?? 'YES'); ?></span>';
            actionInput.value = 'away';
        } else {
            btn.className = 'presence-btn is-away';
            btn.innerHTML = '<span>🔲 <?php echo e($taal['NO'] ?? 'NO'); ?></span>';
            actionInput.value = 'present';
        }

        fetch('employee_proc.php', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).catch(err => {
            console.error(err);
        });
    }
}
</script>

<?php echo backurl("."); ?>

</body>
</html>
