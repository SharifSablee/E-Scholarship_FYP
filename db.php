<?php
// server
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "escholarship";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
