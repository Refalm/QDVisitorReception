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
<form>
<fieldset>
<legend>Employees present</legend>
<?php
if ($whoemployees = $dbconnection->query("SELECT * FROM employee ORDER BY name ASC"))
{
	if ($whoemployees->num_rows > 0)
	{
		echo "<table>";
		echo "<tr style=\"font-size:32px\"><th>Name</th><th>Present</th></tr>";

		while ($row = $whoemployees->fetch_object())
		{
			echo "<tr>";
			echo "<td style=\"padding:2px 2px 2px 2px;font-size:32px;\">" . $row->name . "</td>";
			if ($row->present == 0)
			{
				echo "<td><input type=\"button\" name=\"itsoffrn\" value=\"⬜️\" style=\"width:100%;height:100%;\" /></td>";
			}
			
			else if ($row->present == 1)
			{
				echo "<td><input type=\"button\" name=\"itsonrn\" value=\"☑️\" style=\"width:100%;height:100%;\" /></td>";
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