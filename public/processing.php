<?php
require_once("../configuration.php");
require_once("sub/back.php");
require_once("sub/taal.php");

$mysqltime = date("Y-m-d H:i:s");
?><!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="./style.css" />
<?php
if((isset($_POST['visitorname'])) && (isset($_POST['visitormail'])) && (isset($_POST['visitororg'])))
{
	$visitorname = mysqli_real_escape_string($dbconnection, $_POST['visitorname']);
	$visitormail = mysqli_real_escape_string($dbconnection, $_POST['visitormail']);
	$visitororg = mysqli_real_escape_string($dbconnection, $_POST['visitororg']);
	$visitorhost = mysqli_real_escape_string($dbconnection, $_POST['visitorhost']);
	
	$checkvisitorname = $_POST['visitorname'];
	$check = mysqli_query($dbconnection,"SELECT * FROM visitor WHERE visitorname = '".$checkvisitorname."'");
	
	if (($insert = $dbconnection->prepare("INSERT INTO visitor (visitorname, visitormail, visitororg, visitorhost, arrivetime, departtime) VALUES ('".$visitorname."','".$visitormail."','".$visitororg."','".$visitorhost."','".$mysqltime."','2038-01-19 03:14:07')")) && (mysqli_num_rows($check)==0))
	{
		$insert->execute();
		$insert->close();
		echo "<meta http-equiv=\"refresh\" content=\"60; URL=.\" /></head><body id=\"success\"><span class=\"bigfont\">😺</span>\n<br /><br /><span class=\"tekst_header\">".$taal['VISITORPROC_YEE'].", $visitorname!</span>";
	}
	else
	{
		echo "<meta http-equiv=\"refresh\" content=\"60; URL=.\" /></head><body id=\"context\"><span class=\"bigfont\">😼</span>\n<br /><br /><span class=\"tekst_header\">".$taal['VISITORPROC_WUT']."</span>";
	}
	
	$dbconnection->close();
}
else
{
	echo "</head><body id=\"error\"><span class=\"bigfont\">🙀</span>\n<br /><br /><span class=\"tekst_header\">".$taal['DBERROR']."</span><br /><br /><span class=\"tekst_code\">" . $dbconnection->error . "</span>";
	$dbconnection->close();
}

echo backurl(".");
?>
</body>
</html>