<?php
// include 'config.php'; // Include database connection


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

// Fetch the three most searched destinations
$stmt = $conn->prepare("SELECT location FROM search_queries ORDER BY search_count DESC LIMIT 3");
$stmt->execute();
$result = $stmt->get_result();

$popular_destinations = array();
while ($row = $result->fetch_assoc()) {
    $popular_destinations[] = $row;
}

echo json_encode($popular_destinations);

$stmt->close();
$conn->close();
?>
