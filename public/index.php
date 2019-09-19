<?php
require_once("../configuration.php");

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
		<span class="bigfont">👨🏼‍💻</span><br /><br /><span class="tekst">Employee</span>
	</button>
</a>

<a href="./visitor_land.php" class="nodecoration">
	<button class="big spacing">
		<span class="bigfont">🚶🏼‍</span><br /><br /><span class="tekst">Visitor</span>
	</button>
</a>

<div class="clear_both"></div>

<div id="taal"><a href="./?lang=nl" class="nodecoration"><img src="./1F1F3-1F1F1.png" alt="🇳🇱" /></a> <a href="./?lang=en" class="nodecoration"><img src="./1F1EC-1F1E7.png" alt="🇬🇧"/ ></a></div>

</body>
</html>
