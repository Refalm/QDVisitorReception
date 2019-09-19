<?php
// <Language support>
session_start();

if(isSet($_GET['taal']))
{
	$taal = $_GET['taal'];

	// register the session and set the cookie
	$_SESSION['taal'] = $taal;

	setcookie('taal', $taal, time() + (3600 * 24 * 30));
}

	else if(isSet($_SESSION['taal']))
	{
		$taal = $_SESSION['taal'];
	}

	else if(isSet($_COOKIE['taal']))
	{
		$taal = $_COOKIE['taal'];
	}

	else
	{
		$taal = 'en';
	}

switch ($taal)
{
	case 'en':
		$taalbestand = 'en.php';
		break;

	case 'nl':
		$taalbestand = 'nl.php';
		break;

	case 'de':
		$taalbestand = 'de.php';
		break;

	default:
		$taalbestand = 'en.php';
}

include_once 'taal/'.$taalbestand;
// </Language support>
?>