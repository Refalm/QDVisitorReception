<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/back.php");
require_once(__DIR__ . "/sub/taal.php");

$sessionTimeout = 300; // 5 minutes
$maxAttempts = 5;
$lockoutTime = 60; // 1 minute lockout

// Initialize rate limiting in session
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_until'] = 0;
}

$now = time();
$error = null;

// Check if locked out
if ($_SESSION['lockout_until'] > $now) {
    $remaining = $_SESSION['lockout_until'] - $now;
    $error = sprintf($taal['Please_wait'] ?? 'Please wait %ss...', $remaining);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pincode'])) {
    $pincode = (string)$_POST['pincode'];
    
    // Constant-time string comparison against configured PIN
    if (hash_equals($staffpin, $pincode)) {
        // Reset attempts
        $_SESSION['login_attempts'] = 0;
        $_SESSION['lockout_until'] = 0;
        $_SESSION['employee_auth'] = true;
        $_SESSION['employee_auth_time'] = $now;
    } else {
        $_SESSION['login_attempts']++;
        if ($_SESSION['login_attempts'] >= $maxAttempts) {
            $_SESSION['lockout_until'] = $now + $lockoutTime;
            $error = $taal['Too_many_attempts'] ?? 'Too many attempts. Locked for 60s.';
        } else {
            $error = $taal['Invalid_pincode'] ?? 'Invalid PIN code';
        }
    }
}

// Check session authentication status
$isAuthenticated = false;
if (!empty($_SESSION['employee_auth']) && !empty($_SESSION['employee_auth_time'])) {
    if (($now - (int)$_SESSION['employee_auth_time']) < $sessionTimeout) {
        $isAuthenticated = true;
        $_SESSION['employee_auth_time'] = $now; // Refresh activity timestamp
    } else {
        unset($_SESSION['employee_auth'], $_SESSION['employee_auth_time']);
    }
}

// If not authenticated, show modern PIN Pad
if (!$isAuthenticated) {
    ?><!DOCTYPE html>
    <html lang="<?php echo e($_SESSION['taal'] ?? 'en'); ?>">
    <head>
        <title>QDVisitorReception - <?php echo e($taal['Employees_present'] ?? 'Staff Access'); ?></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="./style.css">
        <script src="./kiosk.js" defer></script>
    </head>
    <body id="context">
        <header class="headerbar">
            <div class="headerbar-left">
                <a href="./visitor_land.php" class="back-btn">
                    <span>⬅️</span>
                    <span><?php echo e($taal['Back'] ?? 'Back'); ?></span>
                </a>
            </div>
            <div class="headerbar-center">
                <span class="headerbar-title"><?php echo e($taal['Employees_present'] ?? 'Staff Access'); ?></span>
            </div>
            <div class="headerbar-right">
                <?php echo render_lang_switcher(); ?>
            </div>
        </header>

        <main class="content-wrapper">
            <div class="card numpad-container">
                <h1><?php echo e($taal['Employees_present'] ?? 'Staff PIN'); ?></h1>
                <p style="color:var(--text-muted);font-size:15px;margin:0 0 16px 0;"><?php echo e($taal['Enter_pincode'] ?? 'Enter staff PIN code:'); ?></p>
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
        </main>
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
        <?php include __DIR__ . '/sub/logo.php'; ?>
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
<title>QDVisitorReception - <?php echo e($taal['Employees_present'] ?? 'Employees Present'); ?></title>
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
        <a href="./visitor_land.php" class="back-btn">
            <span>⬅️</span>
            <span><?php echo e($taal['Back'] ?? 'Back'); ?></span>
        </a>
    </div>
    <div class="headerbar-center">
        <span class="headerbar-title"><?php echo e($taal['Employees_present'] ?? 'Employees Present'); ?></span>
    </div>
    <div class="headerbar-right">
        <?php echo render_lang_switcher(); ?>
    </div>
</header>

<main class="content-wrapper">
    <div class="card">
        <h1><?php echo e($taal['Employees_present'] ?? 'Employees Present'); ?></h1>
        
        <div class="search-wrapper" style="margin-top:16px;">
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
                                    <span>🔳 <?php echo e($taal['YES'] ?? 'Present'); ?></span>
                                <?php else: ?>
                                    <span>🔲 <?php echo e($taal['NO'] ?? 'Away'); ?></span>
                                <?php endif; ?>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align:center;padding:48px 20px;color:var(--text-muted);font-size:18px;">
                    <span style="font-size:48px;">🗇</span><br><br>
                    <?php echo e($taal['Employee_list_empty'] ?? 'The employee list is empty...'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

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
            btn.innerHTML = '<span>🔳 <?php echo e(addslashes($taal['YES'] ?? 'Present')); ?></span>';
            actionInput.value = 'away';
        } else {
            btn.className = 'presence-btn is-away';
            btn.innerHTML = '<span>🔲 <?php echo e(addslashes($taal['NO'] ?? 'Away')); ?></span>';
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

<?php include __DIR__ . '/sub/logo.php'; ?>

</body>
</html>
