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

table, th, td
{
	border:1px solid black;
}

table
{
	border-collapse:collapse;
}

th
{
	text-align:left;
}
</style>
</head>
<body>
<img src="<?php echo "$logo"; ?>.png" alt="<?php echo "$logo"; ?>" style="position:fixed;right:0px;bottom:0px;z-index:-1;" />
<form method="post" action="employee_proc.php">
<fieldset>
<legend>Employees present</legend>
<?php
if ($whoemployees = $dbconnection->query("SELECT * FROM employee ORDER BY name ASC"))
{
	if ($whoemployees->num_rows > 0)
	{
		echo "<table style=\"padding:0px 0px 0px 0px;\">";
		echo "<tr style=\"font-size:32px;padding:0px 0px 0px 0px;\"><th>Name</th><th>Present</th></tr>";

		while ($row = $whoemployees->fetch_object())
		{
			echo "\n<tr>";
			echo "<td style=\"padding:0px 0px 0px 0px;font-size:32px;\">" . $row->name . "</td>";
			if ($row->present == 0)
			{
				echo "<td style=\"background:#d4d4d4;text-align:center;\"><input type=\"submit\" name=\"" . $row->id . "\" value=\"🔲 NO\" style=\"border:0px;-webkit-appearance:none;width:100%;height:38px;background:#d4d4d4;color:#0e141f;\" /></td>";
			}
			
			else if ($row->present == 1)
			{
				echo "<td style=\"background:#3689e6;text-align:center;\"><input type=\"submit\" name=\"" . $row->id . "\" value=\"🔳 YES\" style=\"border:0px;-webkit-appearance:none;width:100%;height:38px;background:#3689e6;color:#fafafa;\" /></td>";
			}
			echo "</tr>";
		}
		
		echo "</table>";
	}

	else
	{
		echo "<span style=\"font-size:128px\">🗇</span><br /><br />The employee list is empty...";
	}
}

else
{
	echo "<span style=\"font-size:128px\">🙀</span><br /><br />Connection to the database failed or something, get the sysadmin.<br /><br />" . $dbconnection->error;
}

$dbconnection->close();
?>
</fieldset>
</form>

<div style="position:fixed;left:0px;bottom:0px;top:auto;right:auto;"><a href="." style="text-decoration:none;"><button style="font-size:24px;cursor:pointer;">⬅️ Back</button></a></div>

</body>
</html>