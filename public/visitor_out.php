<?php
include('../configuration.php');
require_once("sub/back.php");
?><!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<link rel="stylesheet" href="./style.css" />
<?php
if((isset($_POST['visitorname'])))
{
	echo "</head><body id=\"context\">";
	$visitorname = mysqli_real_escape_string($dbconnection, $_POST['visitorname']);
	
	if ($whovisitors = $dbconnection->query("SELECT * FROM visitor WHERE visitorname = '$visitorname' AND departtime IS NULL ORDER BY arrivetime DESC"))
	{
		if ($whovisitors->num_rows > 0)
		{
			echo "<form><fieldset><legend>Search results</legend><table class=\"liteborder regular readablefont\">";
			echo "<tr><th class=\"liteborder\">Name</th><th class=\"liteborder\">E-mail</th><th class=\"liteborder\">Organisation</th><th class=\"liteborder\">Host</th><th class=\"liteborder\">Arrival</th><th class=\"liteborder\"></th></tr>";

			while ($row = $whovisitors->fetch_object())
			{
				echo "<tr>";
				echo "<td class=\"liteborder\">" . $row->visitorname . "</td>";
				echo "<td class=\"liteborder\">" . $row->visitormail . "</td>";
				echo "<td class=\"liteborder\">" . $row->visitororg . "</td>";
				echo "<td class=\"liteborder\">" . $row->visitorhost . "</td>";
				echo "<td class=\"liteborder\">" . $row->arrivetime . "</td>";
				echo "<td class=\"liteborder\"><abbr title=\"Check out\" class=\"nodecoration\"><a href=\"visitor_checkout.php?visitorname=" . $row->visitorname . "\" class=\"nodecoration\">🚪🚶🏼</a></abbr></td>";
				echo "</tr></legend></fieldset></form>";
			}

			echo "</table><div id=\"info\"><div id=\"info_emoji\">ℹ</div><div id=\"info_content\">Press \"🚪🚶🏼\" to check out.</div></div>";
		}
		
		else if (($outtahere = $dbconnection->query("SELECT * FROM visitor WHERE visitorname = '$visitorname' AND departtime IS NOT NULL")) && $outtahere->num_rows > 0)
		{
			echo "<meta http-equiv=\"refresh\" content=\"60; URL=.\" /></head><body id=\"context\">";
			echo "<span class=\"bigfont\">😼</span><br /><br />You're already checked out, $visitorname! Thanks for stopping by.";
			echo backurl(".");
		}

		else
		{
			echo "</head><body id=\"error\">";
			echo "<span class=\"bigfont\">🤔</span><br /><br />Hmmm... couldn't find \"$visitorname\"...";
			echo backurl("./visitor_out.php");
		}
	}
	
	

	else
	{
		echo "</head><body id=\"context\"><span class=\"bigfont\">🙀</span><br /><br />Connection to the database failed or something, get the sysadmin.<br /><br />" . $dbconnection->error;
	}

}

else
{
	echo "</head><body id=\"context\">
	<form id=\"searchname\" method=\"post\" action=\"" .$_SERVER['PHP_SELF']. "\"><fieldset><legend>Name search</legend><input id=\"visitorname\" name=\"visitorname\" type=\"text\" placeholder=\"Search for your name\" /><input id=\"submitname\" type=\"submit\" value=\"🔎\" /></fieldset></form><div id=\"info\"><div id=\"info_emoji\">ℹ</div><div id=\"info_content\">Type your name in the search bar, and hit \"Enter\" or the \"🔎\" button.</div></div>";
	echo backurl(".");
}

$dbconnection->close();
?>
</body>
</html>