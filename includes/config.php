<?php 
//Duomenų bazė
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','PG73121A');
//$servername = "localhost";
//$username = "PG73121A";
//$password = "jkm_PG73121A";
//$dbname = "PG73121A";
//$dbh = mysqli_connect($servername, $username, $password, $dbname);

try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>