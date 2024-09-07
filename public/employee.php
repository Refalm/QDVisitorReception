<?php
require_once('../configuration.php');
require_once("sub/back.php");
require_once("sub/taal.php");

// Start session to store pincode if not already started
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// Check if pincode is submitted
if (isset($_POST['pincode'])) {
	if ($_POST['pincode'] === $employee_pincode) {
		$_SESSION['authenticated'] = true;
	} else {
		$error = "Incorrect pincode.";
	}
}

// Check if user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Pincode</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="./style.css">
	</head>
	<body>
		<form method="post" action="">
			<fieldset>
				<legend>Pincode</legend>
				<?php if (isset($error)) { echo "<p style='color:#7a0000;'>$error</p>"; } ?>
				<input type="password" name="pincode" id="pincode" class="wide" required /><br /><br />
				<input type="submit" value="🔓 <?php echo $taal['INPUT']; ?>" class="wide widesubmit" />
			</fieldset>
		</form>
		<?php
		echo backurl(".");
		?>
	</body>
	</html>
	<?php
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="./style.css" />
</head>
<body id="context">
<?php include 'sub/logo.php'; ?>
<form method="post" action="employee_proc.php">
<fieldset>
<legend><?php echo $taal['Employees_present']; ?></legend>
<?php
if ($whoemployees = $dbconnection->query("SELECT * FROM employee ORDER BY name ASC"))
{
	if ($whoemployees->num_rows > 0)
	{
		echo "<table class=\"lite liteborder\">";
		echo "<tr class=\"lite\"><th class=\"liteborder\">".$taal['Name']."</th><th class=\"liteborder\">".$taal['Present']."</th></tr>";

		while ($row = $whoemployees->fetch_object())
		{
			echo "\n<tr>";
			echo "<td class=\"liteborder litename\">" . $row->name . "</td>";
			if ($row->present == 0)
			{
				echo "<td class=\"liteborder no\"><input type=\"submit\" name=\"" . $row->id . "\" value=\"🔲 ".$taal['NO']."\" class=\"no\" /></td>";
			}

			else if ($row->present == 1)
			{
				echo "<td class=\"liteborder yes\"><input type=\"submit\" name=\"" . $row->id . "\" value=\"🔳 ".$taal['YES']."\" class=\"yes\" /></td>";
			}
			echo "</tr>";
		}

		echo "</table>";
	}

	else
	{
		echo "<span class=\"bigfont\">🗇</span><br /><br />The employee list is empty...";
	}
}

else
{
	echo "<span class=\"bigfont\">🙀</span><br /><br />Connection to the database failed or something, get the sysadmin.<br /><br />" . $dbconnection->error;
}

$dbconnection->close();
?>
</fieldset>
</form>

<?php
echo backurl(".");
?>

</body>
</html>
