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
				echo "🙀<br>" . $dbconnection->error;
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
<meta charset="UTF-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="QDVisitorRegistration">
<meta name="application-name" content="QDVisitorRegistration">
<link rel="stylesheet" href="./style.css">
<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192" href="favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
<link rel="manifest" href="favicon/manifest.json">
<meta name="msapplication-TileColor" content="#e1e1e1">
<meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#e1e1e1">
</head>
<body id="landing">
<?php include 'sub/logo.php'; ?>

<a href="./employee.php" class="nodecoration">
	<button class="big">
		<span class="bigfont">👨🏼‍💻</span><br><br><span class="tekst"><?php echo $taal['Employee']; ?></span>
	</button>
</a>

<a href="./visitor_land.php" class="nodecoration">
	<button class="big spacing">
		<span class="bigfont">🚶🏼‍</span><br><br><span class="tekst"><?php echo $taal['Visitor']; ?></span>
	</button>
</a>

<div class="clear_both"></div>

<div id="taaltaco">

	<div id="taalhint">
	CHANGE LANGUAGE
	</div>

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

</div>

</body>
</html>