<?php
require_once(__DIR__ . "/../configuration.php");
require_once(__DIR__ . "/sub/back.php");
require_once(__DIR__ . "/sub/taal.php");

$activeVisitors = [];
if ($res = $dbconnection->query("SELECT id, visitorname, visitororg, visitorhost, arrivetime FROM visitor WHERE departtime IS NULL ORDER BY arrivetime DESC")) {
    while ($row = $res->fetch_object()) {
        $activeVisitors[] = $row;
    }
    $res->close();
}
?><!DOCTYPE html>
<html lang="<?php echo e($_SESSION['taal'] ?? 'en'); ?>">
<head>
<title>QDVisitorReception - <?php echo e($taal['Leaving'] ?? 'Check Out'); ?></title>
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
        <span class="headerbar-title"><?php echo e($taal['Leaving'] ?? 'Check Out'); ?></span>
    </div>
    <div class="headerbar-right">
        <?php echo render_lang_switcher(); ?>
    </div>
</header>

<main class="content-wrapper">
    <div class="card">
        <h1><?php echo e($taal['Leaving'] ?? 'Check Out'); ?></h1>
        <p style="color:var(--text-muted);font-size:16px;margin-bottom:20px;">
            <?php echo e($taal['INFO_VISITOROUT_SEARCH'] ?? 'Type your name to quickly find your registration:'); ?>
        </p>

        <div class="search-wrapper">
            <span class="search-icon">🔍</span>
            <input type="text" id="visitor-search" class="search-input" placeholder="<?php echo e($taal['Search_for_your_name'] ?? 'Search your name...'); ?>" autofocus autocapitalize="words" autocomplete="off" oninput="filterVisitors()" />
        </div>

        <div id="visitor-list" class="visitor-results-grid">
            <?php if (!empty($activeVisitors)): ?>
                <?php foreach ($activeVisitors as $v): ?>
                    <div class="visitor-card" data-name="<?php echo e(strtolower($v->visitorname)); ?>">
                        <div>
                            <div class="visitor-card-name"><?php echo e($v->visitorname); ?></div>
                            <div class="visitor-card-meta">
                                <span>🏢 <?php echo e($v->visitororg); ?></span>
                                <span>👤 <?php echo e($v->visitorhost); ?></span>
                                <span>🕒 <?php echo e($v->arrivetime); ?></span>
                            </div>
                        </div>
                        <a href="visitor_checkout.php?id=<?php echo (int)$v->id; ?>" class="destructive-action btn-checkout">
                            <span>🚪🚶🏼</span>
                            <span><?php echo e($taal['Check_out'] ?? 'Check Out'); ?></span>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align:center;padding:48px 20px;color:var(--text-muted);font-size:18px;">
                    <span style="font-size:48px;">🗇</span><br><br>
                    <?php echo e($taal['No_visitors_checked_in'] ?? 'No visitors currently checked in.'); ?>
                </div>
            <?php endif; ?>
        </div>
        <div id="no-match" style="display:none;text-align:center;padding:36px;color:var(--text-muted);font-size:18px;">
            <span style="font-size:48px;">🤔</span><br><br>
            <?php echo e($taal['No_matches_found'] ?? 'No matches found...'); ?>
        </div>
    </div>
</main>

<script>
function filterVisitors() {
    const query = document.getElementById('visitor-search').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.visitor-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const name = card.getAttribute('data-name');
        if (name.includes(query)) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    const noMatch = document.getElementById('no-match');
    if (noMatch) {
        noMatch.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
    }
}
</script>

<?php include __DIR__ . '/sub/logo.php'; ?>

</body>
</html>
