<?php
require_once("../configuration.php");
require_once("sub/back.php");

$mysqltime = date("Y-m-d H:i:s");
?><!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="./style.css" />
<?php
if (isset($_GET['visitorname']))
{
	$visitorname = mysqli_real_escape_string($dbconnection, $_GET['visitorname']);

	if ($querysearch = $dbconnection->prepare("UPDATE visitor SET departtime = '".$mysqltime."' WHERE visitorname = '$visitorname'"))
	{
		$querysearch->execute();
		$querysearch->close();
		echo "<meta http-equiv=\"refresh\" content=\"60; URL=.\" /></head><body id=\"success\"><span class=\"bigfont\">😸</span>\n<br /><br /><span class=\"tekst_header\">You've been checked out, $visitorname! Thanks for stopping by.</span>";
		include 'sub/logo.php';
	}
	else
	{
		echo "<body id=\"error\"><span class=\"bigfont\">🙀</span>\n<br /><br /><span class=\"tekst_header\">Connection to the database failed or something, get the sysadmin.</span><br /><br /><span class=\"tekst_code\">" . $dbconnection->error . "</span>";
		$dbconnection->close();
	}
}
else
{
	header("Location: index.php");
}

echo backurl(".");

?>
</body>
</html>