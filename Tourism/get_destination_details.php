<?php
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

error_log("GET parameters: " . print_r($_GET, true));
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $destination_id = intval($_GET['id']);
    error_log("Fetching details for destination ID: " . $destination_id); // Debug log

    $stmt = $conn->prepare("SELECT name, description, location, distance, towns, cost FROM destinations WHERE destination_id = ?");
    $stmt->bind_param("i", $destination_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $details = $result->fetch_assoc();
        echo json_encode($details);
    } else {
        echo json_encode(['error' => 'Destination not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$conn->close();
?>
