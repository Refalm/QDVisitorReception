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
		$taalnlset = " selected=\"selected\"";
		$taalenset = "";
		$taalfyset = "";
	}

	else if ($_COOKIE["taal"] == "en")
	{
		$taalenset = " selected=\"selected\"";
		$taalnlset = "";
		$taalfyset = "";
	}
	
	else if ($_COOKIE["taal"] == "fy")
	{
		$taalfyset = " selected=\"selected\"";
		$taalenset = "";
		$taalnlset = "";
	}
}
	else
	{
		$taalenset = " selected=\"selected\"";
		$taalnlset = "";
		$taalfyset = "";
	}
?>
	<select onchange="location = this.value;" id="taal">
		<option value="./?taal=en"<?php echo $taalenset; ?>>🇬🇧 English</option>
		<option value="./?taal=fy"<?php echo $taalfyset; ?>>🏁 Frysk</option>
		<option value="./?taal=nl"<?php echo $taalnlset; ?>>🇳🇱 Nederlands</option>
	</select>
</div>

</body>
</html>
