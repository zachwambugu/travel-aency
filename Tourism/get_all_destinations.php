<?php
// fetches all destinations from the database

header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tourism";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3306, '/opt/lampp/var/mysql/mysql.sock');

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

//gets all destinations
$sql = "SELECT name, destination_id, location, image_path FROM destinations";
$result = $conn->query($sql);

$destinations = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
} 

$conn->close();

echo json_encode($destinations);
?>
