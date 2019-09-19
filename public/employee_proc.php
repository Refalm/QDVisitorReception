<?php
require_once("../configuration.php");
require_once("sub/back.php");
?><!DOCTYPE html>
<html>
<head>
<title>QDVisitorReception</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="./style.css" />
</head>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	echo "<body id=\"context\">";
	echo backurl(".");
	include 'sub/logo.php';
	
	foreach ($_POST as $name => $value)
	{
		if ($whoemployees = $dbconnection->query("SELECT * FROM employee WHERE id = $name"))
		{
			
			if($value == "🔳 YES")
			{
				
				if($putonaway = $dbconnection->prepare("UPDATE employee SET present = 0 WHERE id = $name"))
				{
					$putonaway->execute();
					$putonaway->close();
				}
			}
			
			if($value == "🔲 NO")
			{
				
				if($putonpresent = $dbconnection->prepare("UPDATE employee SET present = 1 WHERE id = $name"))
				{
					$putonpresent->execute();
					$putonpresent->close();
				}
			}
		}
	}

echo "<meta http-equiv=\"refresh\" content=\"0; URL=./employee.php\">";
echo "</body>";
}

else
{
	echo "<body id=\"error\">";
	echo backurl(".");
	echo "<span class=\"bigfont\">😿</span>\n<br /><br /><span class=\"tekst_header\">Computer says no.</span>";
	echo "</body>";
}
?>
</html>