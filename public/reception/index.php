<!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" />
<style>
body
{
	font-family:'Georgia',serif;
	background:#fafafa;
}
</style>
</head>
<body>
<?php
include('../../configuration.php');

echo "<h1>Visitors</h1>";

if ($whovisitors = $dbconnection->query("SELECT * FROM visitor ORDER BY arrivetime DESC"))
{
	if ($whovisitors->num_rows > 0)
	{
		echo "<table border=\"1\" cellpadding=\"10\">";
		echo "<tr><th>Name</th><th>E-mail</th><th>Organisation</th><th>Host</th><th>Arrived</th><th>Departed</th><th></th></tr>";

		while ($row = $whovisitors->fetch_object())
		{
			echo "<tr>";
			echo "<td>" . $row->visitorname . "</td>";
			echo "<td>" . $row->visitormail . "</td>";
			echo "<td>" . $row->visitororg . "</td>";
			echo "<td>" . $row->visitorhost . "</td>";
			echo "<td>" . $row->arrivetime . "</td>";
			echo "<td>" . $row->departtime . "</td>";
			echo "<td><abbr title=\"Delete entry\" style=\"text-decoration:none\"><a href=\"delete.php?visitorname=" . $row->visitorname . "\" style=\"text-decoration:none\">❌</a></abbr></td>";
			echo "</tr>";
		}
		
		echo "</table>";
	}

	else
	{
		echo "<span style=\"font-size:128px\">🗇</span><br /><br />The visitor list is empty...";
	}

	echo "<br /><hr />";

	echo "<h1>Employees</h1>";

	if ($whoemployees = $dbconnection->query("SELECT * FROM employee ORDER BY name"))
	{
		if ($whoemployees->num_rows > 0)
		{
			echo "<table border=\"1\" cellpadding=\"10\">";
			echo "<tr><th>Name</th><th></th></tr>";
	
			while ($row = $whoemployees->fetch_object())
			{
				echo "<tr>";
				echo "<td>" . $row->name . "</td>";
				echo "<td><abbr title=\"Sack employee\" style=\"text-decoration:none\"><a href=\"delete.php?name=" . $row->name . "\" style=\"text-decoration:none\">❌</a></abbr></td>";
				echo "</tr>";
			}
			
			echo "</table>";
			echo "<form id=\"werknemer\" method=\"post\" action=\".\"><fieldset><legend>New employee</legend><label for=\"employeename\">Employee name</label><br /><input name=\"employeename\" type=\"text\" placeholder=\"Henk de Vries\" required class=\"wide\" /><br /><input name=\"submit\" type=\"submit\" value=\"🖋 New employee\" class=\"wide widesubmit\" /></fieldset></form>";
		}
	}
	
	else
	{
		echo "<span style=\"font-size:128px\">🗇</span><br /><br />The employee list is empty...";
	}

	if((isset($_POST['employeename'])))
	{
		$employeename = mysqli_real_escape_string($dbconnection, $_POST['employeename']);
		
		$checkemployeename = $_POST['employeename'];
		$check = mysqli_query($dbconnection,"SELECT * FROM employee WHERE name = '".$checkemployeename."'");
		
		if (($insert = $dbconnection->prepare("INSERT INTO employee (name, present) VALUES ('".$employeename."',0)")) && (mysqli_num_rows($check)==0))
		{
			$insert->execute();
			$insert->close();
			echo "<meta http-equiv=\"refresh\" content=\"60; URL=.\" /></head><body id=\"success\"><span class=\"bigfont\">😺</span>\n<br /><br /><span class=\"tekst_header\">$employeename entered.</span>";
		}
		else
		{
			echo "<meta http-equiv=\"refresh\" content=\"60; URL=.\" /></head><body id=\"context\"><span class=\"bigfont\">😼</span>\n<br /><br /><span class=\"tekst_header\">$employeename is already on the list.</span>";
		}
	}
}

else
{
	echo "<span style=\"font-size:128px\">🙀</span><br /><br />Connection to the database failed or something, get the sysadmin.<br /><br />" . $dbconnection->error;
}

$dbconnection->close();
?>

<div style="position:fixed;left:0px;bottom:0px;top:auto;right:auto;"><a href=".." style="text-decoration:none;"><button style="font-size:24px;cursor:pointer;">⬅️ Back</button></a></div>

</body>
</html>