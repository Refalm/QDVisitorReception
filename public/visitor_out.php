<!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<style>
body
{
	font-family:'Georgia',serif;
	background:#d4d4d4;
}

table
{
	border-collapse:collapse;
}

form
{
	background:#fafafa;
}

input#visitorname
{
	width:80%;height:40px;
}

input#submitname
{
	font-size:20px;
	height:40px;
}
</style>
</head>
<body>
<?php
include('../configuration.php');

if((isset($_POST['visitorname'])))
{
	$visitorname = mysqli_real_escape_string($dbconnection, $_POST['visitorname']);
	
	if ($whovisitors = $dbconnection->query("SELECT * FROM visitor WHERE visitorname = '$visitorname' AND departtime IS NULL ORDER BY arrivetime DESC"))
	{
		if ($whovisitors->num_rows > 0)
		{
			echo "<form><fieldset><legend>Search results</legend><table border=\"1\" cellpadding=\"10\">";
			echo "<tr><th>Name</th><th>E-mail</th><th>Organisation</th><th>Host</th><th>Arrival</th><th></th></tr>";

			while ($row = $whovisitors->fetch_object())
			{
				echo "<tr>";
				echo "<td>" . $row->visitorname . "</td>";
				echo "<td>" . $row->visitormail . "</td>";
				echo "<td>" . $row->visitororg . "</td>";
				echo "<td>" . $row->visitorhost . "</td>";
				echo "<td>" . $row->arrivetime . "</td>";
				echo "<td><abbr title=\"Check out\" style=\"text-decoration:none\"><a href=\"visitor_checkout.php?visitorname=" . $row->visitorname . "\" style=\"text-decoration:none\">🚪🚶</a></abbr></td>";
				echo "</tr></legend></fieldset></form>";
			}

			echo "</table><div style=\"font-family:sans-serif;position:fixed;right:5px;left:auto;top:auto;bottom:5px;border:1px solid #000000;width:300px;background:#fafafa;\"><div style=\"background:#0078D7;color:#fff;text-align:center;margin:2px 2px 2px 2px;\">ℹ</div><div style=\"margin:2px 2px 2px 2px;\">Press \"🚪🚶\" to check out.</div></div>";
		}
		
		else if (($outtahere = $dbconnection->query("SELECT * FROM visitor WHERE visitorname = '$visitorname' AND departtime IS NOT NULL")) && $outtahere->num_rows > 0)
		{
			echo "<meta http-equiv=\"refresh\" content=\"60; URL=.\" /><span style=\"font-size:128px\">😹</span><br /><br />You're already checked out, $visitorname! Thanks for stopping by.<div style=\"position:fixed;left:0px;bottom:0px;top:auto;right:auto;\"><a href=\".\" style=\"text-decoration:none;\"><button style=\"font-size:24px;cursor:pointer;\">⬅️ Back</button></a></div>";
		}

		else
		{
			echo "<span style=\"font-size:128px\">🤔</span><br /><br />Hmmm... couldn't find \"$visitorname\"...<div style=\"position:fixed;left:0px;bottom:0px;top:auto;right:auto;\"><a href=\"./visitor_out.php\" style=\"text-decoration:none;\"><button style=\"font-size:24px;cursor:pointer;\">⬅️ Back</button></a></div>";
		}
	}
	
	

	else
	{
		echo "<span style=\"font-size:128px\">🙀</span><br /><br />Connection to the database failed or something, get the sysadmin.<br /><br />" . $dbconnection->error;
	}

}

else
{
	echo "<form id=\"searchname\" method=\"post\" action=\"" .$_SERVER['PHP_SELF']. "\"><fieldset><legend>Name search</legend><input id=\"visitorname\" name=\"visitorname\" type=\"text\" placeholder=\"Search for your name\" /><input id=\"submitname\" type=\"submit\" value=\"🔎\" /></fieldset></form><div style=\"font-family:sans-serif;position:fixed;right:5px;left:auto;top:auto;bottom:5px;border:1px solid #000000;width:500px;background:#fafafa;\"><div style=\"background:#0078D7;color:#fff;text-align:center;margin:2px 2px 2px 2px;\">ℹ</div><div style=\"margin:2px 2px 2px 2px;\">Type your name in the search bar, and hit \"Enter\" or the \"🔎\" button.</div></div><div style=\"position:fixed;left:0px;bottom:0px;top:auto;right:auto;\"><a href=\".\" style=\"text-decoration:none;\"><button style=\"font-size:24px;cursor:pointer;\">⬅️ Back</button></a></div>";
}

$dbconnection->close();
?>
</body>
</html>