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
<form method="post" action="employee_proc.php">
<fieldset>
<legend>Employees present</legend>
<?php
if ($whoemployees = $dbconnection->query("SELECT * FROM employee ORDER BY name ASC"))
{
	if ($whoemployees->num_rows > 0)
	{
		echo "<table class=\"lite liteborder\">";
		echo "<tr class=\"lite\"><th class=\"liteborder\">Name</th><th class=\"liteborder\">Present</th></tr>";

		while ($row = $whoemployees->fetch_object())
		{
			echo "\n<tr>";
			echo "<td class=\"liteborder litename\">" . $row->name . "</td>";
			if ($row->present == 0)
			{
				echo "<td class=\"liteborder no\"><input type=\"submit\" name=\"" . $row->id . "\" value=\"🔲 NO\" class=\"no\" /></td>";
			}
			
			else if ($row->present == 1)
			{
				echo "<td class=\"liteborder yes\"><input type=\"submit\" name=\"" . $row->id . "\" value=\"🔳 YES\" class=\"yes\" /></td>";
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