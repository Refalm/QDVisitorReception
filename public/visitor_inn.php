<?php
require_once('../configuration.php');
require_once("sub/back.php");
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
	<legend>Visitor</legend>
		<label for="visitorname">Name</label>
		<br />
		<input name="visitorname" type="text" placeholder="Gabe Newell" required class="wide" />
		<br />
		<br />
		<label for="visitormail">E-mail address</label>
		<br />
		<input name="visitormail" type="email" placeholder="gaben@valvesoftware.com" required class="wide" />
		<br />
		<br />
		<label for="visitororg">Organisation</label>
		<br />
		<input name="visitororg" type="text" placeholder="Valve Corporation" required class="wide" />
		<br />
		<br />
		<label for="visitorhost">Name of employee you're visiting</label>
		<br />
		<input name="visitorhost" type="text" placeholder="Henk de Vries" required class="wide" />
		<br />
		<br />
		<input name="submit" type="submit" value="🖋 Enter" class="wide widesubmit" />
	</fieldset>
</form>
<?php echo backurl("."); ?>
</body>
</html>