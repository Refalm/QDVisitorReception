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
<body id="context">
<?php include 'sub/logo.php'; ?>
<h1>Visitor registration</h1>
We process the data below for the proper handling of calamities and we will store this data for a maximum of two days:
<ul>
<li>Name;</li>
<li>Organisation you're associated with;</li>
<li>Date and time of arrival and departure;</li>
<li>Information that relates to the person or department you wish to visit.</li>
</ul>
<strong>You have the right to oppose the data processing, and to request the erasure or blocking of your data.</strong>
<br />
<h2>Rules for visitors</h2>
<table>
	<tr><th></th><th></th></tr>
	<tr><td class="centre">📷</td><td>Photography, filming, and/or creating audio recordings, is prohibited without written permission from management.</td></tr>
	<tr><td class="centre">⚡</td><td>When entering an ESD zone, you must follow instructions given by staff.</td></tr>
	<tr><td class="centre">🚶🏼</td><td>Visitors are not allowed to wander the premises by themselves.</td></tr>
</table>
<hr />
<a href="./visitor_inn.php" class="nodecoration"><button class="accept">✅ Accept</button></a>
<?php echo backurl("."); ?>
</body>
</html>