<?php
//Database config
$server = "localhost";
$user = 'root';
$pass = '';
$dbname = 'pd_db';

// Create connection
$conn = new mysqli($server,$user,$pass,$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
