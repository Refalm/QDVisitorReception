<?php
require_once("../configuration.php");

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
}

else
{
	echo "<style>body { background:#ed5353; }</style><span style=\"font-size:128px\">😿</span>\n<br /><br /><span style=\"font=family:'Georgia',serif;font-size:48px;\">Computer says no.</span>";
}
?>
<meta http-equiv="refresh" content="0; URL=./employee.php">