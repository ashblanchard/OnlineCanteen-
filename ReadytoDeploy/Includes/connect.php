<?php

//$dbuser = "campsegg_phpuser";
//$dbpass = "phpuserpw";
//$dbname = "campsegg_seggiecampers";
//$dbhost = "198.91.81.2";

$dbhost = "localhost:3307"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "seggiecampers"; // the name of the database that you are going to use for this project
$dbuser = "phpuser"; // the username that you created, or were given, to access your database
$dbpass = "phpuserpw"; // the password that you created, or were given, to access your database

mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());
mysql_select_db($dbname) or die("MySQL Error: " . mysql_error());

if(!isset($_SESSION['cart'])){
    session_start();
}
?>