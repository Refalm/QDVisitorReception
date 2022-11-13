<?php
include('../../configuration.php');

if (isset($_GET['visitorname']))
{
	$visitorname = mysqli_real_escape_string($dbconnection, $_GET['visitorname']);

	if ($querysearch = $dbconnection->prepare("DELETE FROM visitor WHERE visitorname = '$visitorname'"))
	{
		$querysearch->execute();
		$querysearch->close();
	}
	else
	{
		echo "🙀 Connection to the database failed or something, get the sysadmin. Show them this:<br /><br />" . $dbconnection->error;
		$dbconnection->close();
	}

	header("Location: index.php");
}

if (isset($_GET['name']))
{
	$name = mysqli_real_escape_string($dbconnection, $_GET['name']);

	if ($querysearch = $dbconnection->prepare("DELETE FROM employee WHERE name = '$name'"))
	{
		$querysearch->execute();
		$querysearch->close();
	}
	else
	{
		echo "🙀 Connection to the database failed or something, get the sysadmin. Show them this:<br /><br />" . $dbconnection->error;
		$dbconnection->close();
	}

	header("Location: index.php");
}

else
{
	header("Location: index.php");
}
?>