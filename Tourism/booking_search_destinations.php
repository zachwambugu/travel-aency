<?php
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

//searches from destinations table destnations that start in the typed characters
if (isset($_GET['term'])) {
    $term = $_GET['term'];
    $stmt = $conn->prepare("SELECT name FROM destinations WHERE name LIKE ?");
    $likeTerm = "%" . $term . "%";
    $stmt->bind_param("s", $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $destinations = array();
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row['name'];
    }

    echo json_encode($destinations);
}
?>
