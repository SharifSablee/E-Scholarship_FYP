<?php
// server
$dbhost = "localhost";
$dbuser = "escholarship";
$dbpass = "password";
$dbname = "escholarship";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
