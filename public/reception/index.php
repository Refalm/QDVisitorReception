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

if ($whovisitors = $dbconnection->query("SELECT * FROM visitor ORDER BY visitortime DESC"))
{
	if ($whovisitors->num_rows > 0)
	{
		echo "<table border=\"1\" cellpadding=\"10\">";
		echo "<tr><th>Name</th><th>E-mail</th><th>Organisation</th><th>Time</th><th></th></tr>";

		while ($row = $whovisitors->fetch_object())
		{
			echo "<tr>";
			echo "<td>" . $row->visitorname . "</td>";
			echo "<td>" . $row->visitormail . "</td>";
			echo "<td>" . $row->visitororg . "</td>";
			echo "<td>" . $row->visitortime . "</td>";
			echo "<td><abbr title=\"Delete entry\" style=\"text-decoration:none\"><a href=\"delete.php?visitorname=" . $row->visitorname . "\" style=\"text-decoration:none\">❌</a></abbr></td>";
			echo "</tr>";
		}
		
		echo "</table>";
	}

	else
	{
		echo "<span style=\"font-size:128px\">🗇</span><br /><br />The visitor list is empty...";
	}
}

else
{
	echo "<span style=\"font-size:128px\">🙀</span><br /><br />Connection to the database failed or something, get the sysadmin.<br /><br />" . $dbconnection->error;
}

$dbconnection->close();
?>

<div style="position:fixed;left:0px;bottom:0px;top:auto;right:auto;"><a href="../index.html" style="text-decoration:none;"><button style="font-size:24px;cursor:pointer;">⬅️ Back</button></a></div>

</body>
</html>