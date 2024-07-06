<?php
// selects all destinations in a given price range

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

    $stmt = $conn->prepare("SELECT * FROM destinations WHERE cost BETWEEN ? AND ?");
    $stmt->bind_param("ii", $min_price, $max_price);
    $stmt->execute();
    $result = $stmt->get_result();

    $destinations = [];
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }

    echo json_encode($destinations);

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$conn->close();
?>
