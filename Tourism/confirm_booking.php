<?php

session_start();
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


// if (!isset($_SESSION['user_id'])) {
//     header("Location: ../booking/booking.php");
//     exit();
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $people = $_POST['people'];
    $payment = $_POST['payment'];

    // Assuming you have a way to get the logged-in user ID
    // Replace the following line with your actual user authentication logic
    //$user_id = 1; // Example user ID

    // Get destination ID from the destination name
    $stmt = $conn->prepare("SELECT destination_id FROM destinations WHERE name = ?");
    $stmt->bind_param("s", $destination);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $destination_id = $row['destination_id'];

        // Insert booking data into the bookings table
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, destination_id, booking_date) VALUES (?, ?, ?)");
        $booking_date = $date . ' ' . $time; // Combining date and time
        $stmt->bind_param("iis", $user_id, $destination_id, $booking_date);

        if ($stmt->execute()) {
            echo "Booking confirmed!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Destination not found!";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
