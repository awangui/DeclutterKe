<?php
$dbhost = "localhost";
$dbuser = "root";
//$dbuser = "admin";
$dbpass = "";
//$dbpass = "d3clutt3r";
$dbname = "resale_db";
if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("failed to connect!");
}
