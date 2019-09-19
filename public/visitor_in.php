<?php
require_once("../configuration.php");
require_once("sub/back.php");
require_once("sub/taal.php");
?><!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" /> 
<link rel="stylesheet" href="./style.css" />
</head>
<body id="context">
<?php include 'sub/logo.php'; ?>
<h1><?php echo $taal['VISITORIN_TITLE']; ?></h1>
<?php echo $taal['VISITORIN_HANDLING']; ?>
<br />
<h2><?php echo $taal['VISITORIN_RULESTITLE']; ?></h2>
<table>
	<tr><th></th><th></th></tr>
	<tr><td class="centre">📷</td><td><?php echo $taal['VISITORIN_RULESCAM']; ?></td></tr>
	<tr><td class="centre">⚡</td><td><?php echo $taal['VISITORIN_RULESESD']; ?></td></tr>
	<tr><td class="centre">🚶🏼</td><td><?php echo $taal['VISITORIN_RULESPPL']; ?></td></tr>
</table>
<hr />
<a href="./visitor_inn.php" class="nodecoration"><button class="accept">✅ <?php echo $taal['Accept']; ?></button></a>
<?php echo backurl("."); ?>
</body>
</html>