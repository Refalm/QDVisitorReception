<?php
require_once("../configuration.php");

echo "<body style=\"background:#d4d4d4;\"><img src=\"$logo.png\" alt=\"$logo\" style=\"position:fixed;right:0px;bottom:0px;z-index:-1;\" /><div style=\"position:fixed;left:0px;bottom:0px;top:auto;right:auto;\"><a href=\".\" style=\"text-decoration:none;\"><button style=\"font-size:24px;cursor:pointer;\">⬅️ Back</button></a></div>";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
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
	echo "<style>body { background:#ed5353; }</style><span style=\"font-size:128px\">😿</span>\n<br /><br /><span style=\"font=family:'Georgia',serif;font-size:48px;\">Computer says no.</span><div style=\"position:fixed;left:0px;bottom:0px;top:auto;right:auto;\"><a href=\".\" style=\"text-decoration:none;\"><button style=\"font-size:24px;cursor:pointer;\">⬅️ Back</button></a></div>";
}
?>