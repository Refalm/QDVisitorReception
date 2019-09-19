<?php
require_once("../configuration.php");
include("sub/taal.php");

// <Delete expired visitor entries after two days>
$mysqltime = date("Y-m-d H:i:s");
$minustwodays = strtotime($mysqltime."- 2 days");
$mysqltimeminustwodays = date("Y-m-d H:i:s",$minustwodays);

if ($whovisitors = $dbconnection->query("SELECT * FROM visitor WHERE departtime <= '$mysqltimeminustwodays' AND departtime != 0"))
{
	if ($whovisitors->num_rows > 0)
	{
		while ($row = $whovisitors->fetch_object())
		{
			if ($twophonecallsandyouraccountcanbedeled = $dbconnection->prepare("DELETE FROM visitor WHERE visitorname = '" . $row->visitorname . "'"))
			{
				$twophonecallsandyouraccountcanbedeled->execute();
				$twophonecallsandyouraccountcanbedeled->close();
			}
			else
			{
				echo "🙀<br />" . $dbconnection->error;
				$dbconnection->close();
			}
		}
	}
}
// </Delete expired visitor entries after two days>

?><!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="./style.css" />
</head>
<body id="landing">
<?php include 'sub/logo.php'; ?>

<a href="./employee.php" class="nodecoration">
	<button class="big">
		<span class="bigfont">👨🏼‍💻</span><br /><br /><span class="tekst"><?php echo $taal['Employee']; ?></span>
	</button>
</a>

<a href="./visitor_land.php" class="nodecoration">
	<button class="big spacing">
		<span class="bigfont">🚶🏼‍</span><br /><br /><span class="tekst"><?php echo $taal['Visitor']; ?></span>
	</button>
</a>

<div class="clear_both"></div>

<div id="taal">
<?php
if(isSet($_COOKIE['taal']))
{
	if ($_COOKIE["taal"] == "nl")
	{
		echo "<abbr title=\"English\" class=\"nodecoration\"><a href=\"./?taal=en\" class=\"nodecoration\"><img src=\"./1F1EC-1F1E7.png\" alt=\"🇬🇧\" /></a></abbr>";
	}

	else if ($_COOKIE["taal"] == "en")
	{
		echo "<abbr title=\"Nederlands\" class=\"nodecoration\"><a href=\"./?taal=nl\" class=\"nodecoration\"><img src=\"./1F1F3-1F1F1.png\" alt=\"🇳🇱\" /></a></abbr>";
	}
}
	else
	{
		echo "<abbr title=\"Nederlands\" class=\"nodecoration\"><a href=\"./?taal=nl\" class=\"nodecoration\"><img src=\"./1F1F3-1F1F1.png\" alt=\"🇳🇱\" /></a></abbr>";
	}
?>
</div>

</body>
</html>
