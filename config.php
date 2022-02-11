<?php
$servername = "localhost";
$username = "satan";
$password = "sterling22";
$dbname = "dogshow";

error_reporting(0);
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    echo "Error: Unable to connect to MYSQL. <br>";
    echo "<br> Debugging error:" . mysqli_connect_error();
}


?>