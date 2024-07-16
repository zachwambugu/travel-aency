<?php
$servername = "localhost";
$username = "root"; // Default XAMPP MySQL username
$password = ""; // Default XAMPP MySQL password
$dbname = "tourism";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3306,'/run/mysqld/mysqld.sock');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!-- $socket = "/opt/lampp/var/mysql/mysql.sock"; -->
socket = /run/mysqld/mysqld.sock

