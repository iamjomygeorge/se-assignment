<?php
$host = "localhost";
$username = "root";
$password = "Accesssql.0";
$database = "se_assignment_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>