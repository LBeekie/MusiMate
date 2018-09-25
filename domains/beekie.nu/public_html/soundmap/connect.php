<?php
$servername = "localhost";
$username = "lucasrc157";
$password = "vtyfdgoq";
$dbname = "lucasrc157_fontys";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?> 