<?php 
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "modiste(1)";

// Create conection
$con = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if($con->connect_error){
    die("Connection Failed:" . $con->connect_error);
}
