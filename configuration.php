<?php
# https://stackoverflow.com/questions/55756486/php-mysqli-create-database-if-does-not-exist

require_once("vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['MYSQL_HOST'];
$username = $_ENV['MYSQL_USER'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DATABASE'];
$logo = $_ENV['LOGO'];
$privacymail = $_ENV['PRIVACYMAIL'];

$dbconnection = new mysqli($servername, $username, $password, $database);

if ($dbconnection->connect_error)
{
    die("🙀 Connection to the database failed or something, get the sysadmin. Show them this:<br /><br />" . $dbconnection->connect_error);
	//mysqli_report(MYSQLI_REPORT_ERROR);
}

?>