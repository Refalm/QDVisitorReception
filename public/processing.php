<?php
require_once("../configuration.php");

if((isset($_POST['visitorname'])) && (isset($_POST['visitormail'])) && (isset($_POST['visitororg'])))
{
	$visitorname = mysqli_real_escape_string($dbconnection, $_POST['visitorname']);
	$visitormail = mysqli_real_escape_string($dbconnection, $_POST['visitormail']);
	$visitororg = mysqli_real_escape_string($dbconnection, $_POST['visitororg']);
	
	$checkvisitorname = $_POST['visitorname'];
	$check = mysqli_query($dbconnection,"SELECT * FROM visitor WHERE visitorname = '".$checkvisitorname."'");
	
	if (($insert = $dbconnection->prepare("INSERT INTO visitor (visitorname, visitormail, visitororg) VALUES ('".$visitorname."','".$visitormail."','".$visitororg."')")) && (mysqli_num_rows($check)==0))
	{
		$insert->execute();
		$insert->close();
		echo "<meta http-equiv=\"refresh\" content=\"60; URL=./index.php\" /><style>body { background:#9bdb4d; }</style><span style=\"font-size:128px\">😺</span>\n<br /><br /><span style=\"font=family:'Georgia',serif;font-size:48px;\">Your name has been written in the visitor list, $visitorname!</span>";
	}
	else
	{
		echo "<style>body { background:#ed5353; }</style><span style=\"font-size:128px\">😿</span>\n<br /><br /><span style=\"font=family:'Georgia',serif;font-size:48px;\">Your entry wasn't added,<br />you're probaby already on the visitor list.</span>";
	}
	
	$dbconnection->close();
}
else
{
	echo "<style>body { background:#ed5353; }</style><span style=\"font-size:128px\">🙀</span>\n<br /><br /><span style=\"font=family:'Georgia',serif;font-size:48px;\">Connection to the database failed or something, get the sysadmin.</span><br /><br /><span style=\"font-family:'Monaco','Consolas',monospace;font-size:8px;\">" . $dbconnection->error . "</span>";
}
?>
<div style="position:fixed;left:0px;bottom:0px;top:auto;right:auto;"><a href="./index.php" style="text-decoration:none;"><button style="font-size:24px;cursor:pointer;">⬅️ Back</button></a></div>
