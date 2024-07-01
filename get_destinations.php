<?php
include 'config.php'; // Include database connection

$location = isset($_GET['location']) ? $_GET['location'] : '';

if ($location) {
    $stmt = $conn->prepare("SELECT name, description, location, image_path FROM destinations WHERE location LIKE ?");
    $likeLocation = "%" . $location . "%";
    $stmt->bind_param("s", $likeLocation);
} else {
    $stmt = $conn->prepare("SELECT name, description, location, image_path FROM destinations");
}

$stmt->execute();
$result = $stmt->get_result();

$destinations = array();
while ($row = $result->fetch_assoc()) {
    $destinations[] = $row;
}

echo json_encode($destinations);

$stmt->close();
$conn->close();
?>
