<?php
require_once("../configuration.php");
require_once("sub/back.php");
?><!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="./style.css" />
</head>
<body id="landing">
<?php include 'sub/logo.php'; ?>

<a href="./visitor_out.php" class="nodecoration">
<button class="big">
<span class="bigfont">🚪🚶🏼</span><br /><br /><span class="tekst">Leaving</span>
</button>
</a>

<a href="./visitor_in.php" class="nodecoration">
<button class="big spacing">
<span class="bigfont">🏢🚶🏼</span><br /><br /><span class="tekst">Entering</span>
</button>
</a>

<div class="clear_both"></div>

<?php echo backurl("."); ?>

</body>
</html>
