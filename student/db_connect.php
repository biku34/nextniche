<?php
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Set your DB password
$dbname = "manoraksha";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
