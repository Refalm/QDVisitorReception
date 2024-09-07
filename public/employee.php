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
		$error = "😾";
	}
}

// Check if user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>PIN code</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="./style.css">
	</head>
	<body>
		<form method="post" action="">
			<fieldset>
				<legend>PIN code</legend>
				<div class="numpad">
					<input type="password" name="pincode" id="pincode" class="hidden-input" required />
					<?php for ($i = 1; $i <= 9; $i++): ?>
						<button type="button" onclick="appendNumber(<?php echo $i; ?>)"><?php echo $i; ?></button>
					<?php endfor; ?>
					<button type="button" onclick="clearInput()">⌫</button>
					<button type="button" onclick="appendNumber(0)">0</button>
					<button type="submit">🔓</button>
				</div>
				<div id="display" class="wide"></div>
				<?php if (isset($error)) { echo "<p id='error-message'>$error</p>"; } ?>
			</fieldset>
		</form>
		<script>
			function appendNumber(number) {
				const input = document.getElementById('pincode');
				const display = document.getElementById('display');
				input.value += number;
				display.innerText += '*';
			}

			function clearInput() {
				const input = document.getElementById('pincode');
				const display = document.getElementById('display');
				input.value = '';
				display.innerText = '';
			}

			// Hide error message after 5 seconds
			window.onload = function() {
				const errorMessage = document.getElementById('error-message');
				if (errorMessage) {
					setTimeout(() => {
						errorMessage.style.display = 'none';
					}, 5000);
				}
			}
		</script>
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
