<?php
$servername = "localhost:8080/phpmyadmin";
$username = "root";
$password = "";
$dbname = "ikea";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
