<?php
function backurl($url)
{
    global $taal;
    $backText = $taal['Back'] ?? 'Back';
    return '<div id="back"><a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" class="nodecoration"><button id="back-btn" class="back-btn" type="button">⬅️ ' . htmlspecialchars($backText, ENT_QUOTES, 'UTF-8') . '</button></a></div>';
}
?>
