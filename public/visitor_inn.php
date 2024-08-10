<?php
require_once('../configuration.php');
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
<form id="bezoeker" method="post" action="processing.php">
	<fieldset>
	<legend><?php echo $taal['Visitor']; ?></legend>
		<label for="visitorname"><?php echo $taal['Name']; ?></label>
		<br />
		<input name="visitorname" type="text" placeholder="Gabe Newell" required class="wide" />
		<br />
		<br />
		<label for="visitormail"><?php echo $taal['E-mail_address']; ?></label>
		<br />
		<input name="visitormail" type="email" placeholder="gaben@valvesoftware.com" required class="wide" />
		<br />
		<br />
		<label for="visitororg"><?php echo $taal['Organization']; ?></label>
		<br />
		<input name="visitororg" type="text" placeholder="Valve Corporation" required class="wide" />
		<br />
		<br />
		<label for="visitorhost"><?php echo $taal['NAME_EMPLOYEE4VISIT']; ?></label>
		<br />
		<input name="visitorhost" type="text" placeholder="Henk de Vries" required class="wide" />
		<br />
		<br />
		<input name="submit" type="submit" value="🖋 <?php echo $taal['INPUT']; ?>" class="wide widesubmit" />
	</fieldset>
</form>
<?php echo backurl("."); ?>
</body>
</html>
