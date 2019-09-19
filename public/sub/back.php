<?php
function backurl($url)
{
	if(isSet($_COOKIE['taal']))
	{
		$taal = $_COOKIE['taal'];
		
		if ($_COOKIE["taal"] == "en")
		{
			echo "<div id=\"back\"><a href=\"$url\" class=\"nodecoration\"><button id=\"back\">⬅️ Back</button></a></div>";
		}
			else if ($_COOKIE["taal"] == "nl")
			{
				echo "<div id=\"back\"><a href=\"$url\" class=\"nodecoration\"><button id=\"back\">⬅️ Terug</button></a></div>";
			}
	}

	else
	{
		echo "<div id=\"back\"><a href=\"$url\" class=\"nodecoration\"><button id=\"back\">⬅️ Back</button></a></div>";
	}
	
}
?>