<?php
require_once("../configuration.php");
require_once("sub/back.php");
require_once("sub/taal.php");
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
			echo "<form><fieldset><legend>".$taal['Search_results']."</legend><table class=\"liteborder regular readablefont\">";
			echo "<tr><th class=\"liteborder\">".$taal['Name']."</th><th class=\"liteborder\">".$taal['E-mail_address']."</th><th class=\"liteborder\">".$taal['Organisation']."</th><th class=\"liteborder\">".$taal['Host']."</th><th class=\"liteborder\">".$taal['Arrival']."</th><th class=\"liteborder\"></th></tr>";

			while ($row = $whovisitors->fetch_object())
			{
				echo "<tr>";
				echo "<td class=\"liteborder\">" . $row->visitorname . "</td>";
				echo "<td class=\"liteborder\">" . $row->visitormail . "</td>";
				echo "<td class=\"liteborder\">" . $row->visitororg . "</td>";
				echo "<td class=\"liteborder\">" . $row->visitorhost . "</td>";
				echo "<td class=\"liteborder\">" . $row->arrivetime . "</td>";
				echo "<td class=\"liteborder\"><abbr title=\"".$taal['Check_out']."\" class=\"nodecoration\"><a href=\"visitor_checkout.php?visitorname=" . $row->visitorname . "\" class=\"nodecoration\">🚪🚶🏼</a></abbr></td>";
				echo "</tr></legend></fieldset></form>";
			}

			echo "</table><div id=\"info\"><div id=\"info_emoji\">ℹ</div><div id=\"info_content\">".$taal['INFO_VISITOROUT_PRESS']."</div></div>";
			echo backurl("./visitor_out.php");
		}
		
		else if (($outtahere = $dbconnection->query("SELECT * FROM visitor WHERE visitorname = '$visitorname' AND departtime IS NOT NULL")) && $outtahere->num_rows > 0)
		{
			echo "<meta http-equiv=\"refresh\" content=\"60; URL=.\" /></head><body id=\"context\">";
			echo "<span class=\"bigfont\">😼</span><br /><br />".$taal['VISITOROUT_ALREADY'].", $visitorname! ".$taal['VISITOROUT_THX']."";
			echo backurl(".");
		}

		else
		{
			echo "</head><body id=\"error\">";
			echo "<span class=\"bigfont\">🤔</span><br /><br />Hmmm... \"$visitorname\" ".$taal['VISITOROUT_NOTFOUND']."...";
			echo backurl("./visitor_out.php");
		}
	}
	
	

	else
	{
		echo "</head><body id=\"error\"><span class=\"bigfont\">🙀</span>\n<br /><br /><span class=\"tekst_header\">".$taal['DBERROR']."</span><br /><br /><span class=\"tekst_code\">" . $dbconnection->error . "</span>";
	}

}

else
{
	echo "</head><body id=\"context\">
	<form id=\"searchname\" method=\"post\" action=\"" .$_SERVER['PHP_SELF']. "\"><fieldset><legend>".$taal['Name_search']."</legend><input id=\"visitorname\" name=\"visitorname\" type=\"text\" placeholder=\"".$taal['Search_for_your_name']."\" /><input id=\"submitname\" type=\"submit\" value=\"🔎\" /></fieldset></form><div id=\"info\"><div id=\"info_emoji\">ℹ</div><div id=\"info_content\">".$taal['INFO_VISITOROUT_SEARCH']."</div></div>";
	echo backurl(".");
}

$dbconnection->close();
?>
</body>
</html>