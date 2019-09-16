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
<style>
body
{
	background:#95a3ab;
}

button
{
	cursor:pointer;width:400px;height:400px;float:left;text-align:center;
}

.emoji
{
	font-size:128px;
}

.tekst
{
	font-size:72px;
}
</style>
</head>
<body>
<img src="<?php echo "$logo"; ?>.png" alt="<?php echo "$logo"; ?>" style="position:fixed;right:0px;bottom:0px;z-index:-1;" />

<a href="./employee.php" style="text-decoration:none;">
	<button>
		<span class="emoji">👨‍💻</span><br /><br /><span class="tekst">Employee</span>
	</button>
</a>

<!--
 style="margin-left:50px;"
-->
<a href="./visitor_land.php" style="text-decoration:none;">
	<button style="margin-left:50px;">
		<span class="emoji">🧝‍</span><br /><br /><span class="tekst">Visitor</span>
	</button>
</a>

<div style="clear:both"></div>

</body>
</html>
