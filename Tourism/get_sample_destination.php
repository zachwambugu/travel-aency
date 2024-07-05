<?php
// selects a sample of destination in a given price range
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

if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $min_price = intval($_GET['min_price']);
    $max_price = intval($_GET['max_price']);

    $stmt = $conn->prepare("SELECT destination_id, name, description, location, image_path FROM destinations WHERE cost BETWEEN ? AND ? LIMIT 1");
    $stmt->bind_param("ii", $min_price, $max_price);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $destination = $result->fetch_assoc();
        echo json_encode($destination);
    } else {
        echo json_encode(['error' => 'No destination found in this price range']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$conn->close();
?>
