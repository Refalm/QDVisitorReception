<?php
require_once('../configuration.php');
?><!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" /> 
<style>
body
{
	font-family:'Georgia',serif;
	background:#d4d4d4;
}

form
{
	background:#fafafa;
}

input
{
	width:90%;height:40px;
}
</style>
</head>
<body>
<img src="<?php echo "$logo"; ?>.png" alt="<?php echo "$logo"; ?>" style="position:fixed;right:0px;bottom:0px;z-index:-1;" />
<form id="bezoeker" method="post" action="processing.php">
	<fieldset>
	<legend>Visitor</legend>
		<label for="visitorname">Name</label>
		<br />
		<input name="visitorname" type="text" placeholder="Gabe Newell" required />
		<br />
		<br />
		<label for="visitormail">E-mail address</label>
		<br />
		<input name="visitormail" type="email" placeholder="gaben@valvesoftware.com" required />
		<br />
		<br />
		<label for="visitororg">Organisation</label>
		<br />
		<input name="visitororg" type="text" placeholder="Valve Corporation" required />
		<br />
		<br />
		<label for="visitorhost">Name of employee you're visiting</label>
		<br />
		<input name="visitorhost" type="text" placeholder="Henk de Vries" required />
		<br />
		<br />
		<input name="submit" type="submit" value="🖋 Enter" style="font-weight:bold;font-size:24px;cursor:pointer;" />
	</fieldset>
</form>
<div style="position:fixed;left:0px;bottom:0px;top:auto;right:auto;"><a href="." style="text-decoration:none;"><button style="font-size:24px;cursor:pointer;">⬅️ Back</button></a></div>
</body>
</html>