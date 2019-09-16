<?php
include('../configuration.php');

$mysqltime = date("Y-m-d H:i:s");

if (isset($_GET['visitorname']))
{
	$visitorname = mysqli_real_escape_string($dbconnection, $_GET['visitorname']);

	if ($querysearch = $dbconnection->prepare("UPDATE visitor SET departtime = '".$mysqltime."' WHERE visitorname = '$visitorname'"))
	{
		$querysearch->execute();
		$querysearch->close();
		echo "<meta http-equiv=\"refresh\" content=\"60; URL=./index.php\" /><style>body { background:#9bdb4d; }</style><span style=\"font-size:128px\">😸</span>\n<br /><br /><span style=\"font=family:'Georgia',serif;font-size:48px;\">You've been checked out, $visitorname! Thanks for stopping by.</span>";
	}
	else
	{
		echo "🙀 Connection to the database failed or something, get the sysadmin. Show them this:<br /><br />" . $dbconnection->error;
		$dbconnection->close();
	}
}
else
{
	header("Location: index.php");
}
?>
<img src="<?php echo "$logo"; ?>.png" alt="<?php echo "$logo"; ?>" style="position:fixed;right:0px;bottom:0px;z-index:-1;" />
<div style="position:fixed;left:0px;bottom:0px;top:auto;right:auto;"><a href="." style="text-decoration:none;"><button style="font-size:24px;cursor:pointer;">⬅️ Back</button></a></div>