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



// Fetch location parameter
$location = isset($_GET['location']) ? $_GET['location'] : '';

try {
    if ($location) {
        // Track the search
        $stmt = $conn->prepare("SELECT * FROM search_queries WHERE location = ?");
        $stmt->bind_param("s", $location);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Location exists, increment the count
            $stmt = $conn->prepare("UPDATE search_queries SET search_count = search_count + 1 WHERE location = ?");
            $stmt->bind_param("s", $location);
        } else {
            // Insert new location
            $stmt = $conn->prepare("INSERT INTO search_queries (location, search_count) VALUES (?, 1)");
            $stmt->bind_param("s", $location);
        }
        $stmt->execute();

        // Fetch destinations based on the location
        $stmt = $conn->prepare("SELECT name, description, location, image_path FROM destinations WHERE location LIKE ?");
        $likeLocation = "%" . $location . "%";
        $stmt->bind_param("s", $likeLocation);
    } else {
        // Fetch all destinations if no location is specified
        $stmt = $conn->prepare("SELECT name, description, location, image_path FROM destinations");
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $destinations = array();
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }

    echo json_encode($destinations);
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
} finally {
    $stmt->close();
    $conn->close();
}
?>




