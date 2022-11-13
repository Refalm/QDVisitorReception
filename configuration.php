<?php
require_once("vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['MARIADB_HOST'];
$username = $_ENV['MARIADB_USER'];
$password = $_ENV['MARIADB_PASSWORD'];
$database = $_ENV['MARIADB_DATABASE'];
$logo = $_ENV['LOGO'];
$privacymail = $_ENV['PRIVACYMAIL'];

$dbconnection = new mysqli($servername, $username, $password, $database);

if ($dbconnection->connect_error)
{
    die("🙀 Connection to the database failed or something, get the sysadmin. Show them this:<br /><br />" . $dbconnection->connect_error);
	//mysqli_report(MYSQLI_REPORT_ERROR);
}

?>