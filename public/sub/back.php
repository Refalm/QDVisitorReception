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

			else if ($_COOKIE["taal"] == "fy")
			{
				echo "<div id=\"back\"><a href=\"$url\" class=\"nodecoration\"><button id=\"back\">⬅️ Werom</button></a></div>";
			}

			else if ($_COOKIE["taal"] == "de")
			{
				echo "<div id=\"back\"><a href=\"$url\" class=\"nodecoration\"><button id=\"back\">⬅️ Zurück</button></a></div>";
			}

			else if ($_COOKIE["taal"] == "ie")
			{
				echo "<div id=\"back\"><a href=\"$url\" class=\"nodecoration\"><button id=\"back\">⬅️ Ar ais</button></a></div>";
			}
	}

	else
	{
		echo "<div id=\"back\"><a href=\"$url\" class=\"nodecoration\"><button id=\"back\">⬅️ Back</button></a></div>";
	}

}
?>
