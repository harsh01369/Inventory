<?php
$servername = "localhost";
$username = "root"; // default XAMPP user
$password = ""; // default XAMPP password
$dbname = "donerkings"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>