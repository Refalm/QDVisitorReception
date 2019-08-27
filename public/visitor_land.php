<?php
require_once("../configuration.php");
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

button.big
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

<!--
 style="margin-left:50px;"
-->

<a href="./visitor_out.php" style="text-decoration:none">
<button class="big">
<span class="emoji">📤</span><br /><br /><span class="tekst">Leaving</span>
</button>
</a>

<a href="./visitor_in.php" style="text-decoration:none;">
<button class="big" style="margin-left:50px;">
<span class="emoji">📥‍</span><br /><br /><span class="tekst">Entering</span>
</button>
</a>

<div style="clear:both"></div>

<div style="position:fixed;left:0px;bottom:0px;top:auto;right:auto;"><a href="." style="text-decoration:none;"><button style="font-size:24px;cursor:pointer;">⬅️ Back</button></a></div>

</body>
</html>
