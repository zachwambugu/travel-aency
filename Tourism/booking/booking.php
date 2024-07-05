<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

//fetch user bookings
$user_id = $_SESSION['user_id'];
$sql = "SELECT b.booking_date, b.people, b.payment, d.name AS destination_name 
        FROM bookings b 
        JOIN destinations d ON b.destination_id = d.destination_id 
        WHERE b.user_id = ?";$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Page</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <header>
        <div class="user-info">
            <p>You are logged in as: <?php echo $_SESSION['user_name']; ?></p>
            <a href="../logout.php">Logout</a>
        </div>
        <nav>
            <ul>
                <li><a href="../homepage/home.html">Home</a></li>
                <li><a href="../about-us/about-us.html">About Us</a></li>
                <li><a href="../all-destinations/all-destinations.html">Gallery</a></li>
                <li><a href="../privacy/privacy.html">Privacy Policy</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="booking-form">
            <h1>Book Your Adventure</h1>
            <form action="../confirm_booking.php" method="post">
                <label for="destination">Select Destination:</label>
                <input list="destinationList" id="destination" name="destination" oninput="fetchDestinations()" autocomplete="off">
                <datalist id="destinationList"></datalist>
                
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
                
                
                <label for="people">Number of People:</label>
                <input type="number" id="people" name="people" min="1" required>
                
                <label for="payment">Payment Method:</label>
                <select id="payment" name="payment">
                    <option value="cash on travel day">Cash on travel day</option>
                    <option value="bank">Mpesa</option>
                    
                </select>
                
                <button type="submit">Book Now</button>
            </form>
        </section>
        
        <section class="booking-summary">
            <h2>Booking Summary</h2>
            <?php if (!empty($bookings)): ?>
                <ul>
                    <?php foreach ($bookings as $booking): ?>
                        <li class="booking-item">
                            <strong>Destination:</strong> <?php echo htmlspecialchars($booking['destination_name']); ?><br>
                            <strong> For Date:</strong> <?php echo htmlspecialchars($booking['booking_date']); ?><br>
                            <strong>Number of People:</strong> <?php echo htmlspecialchars($booking['people']); ?><br>
                            <strong>Payment Method:</strong> <?php echo htmlspecialchars($booking['payment']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No bookings found.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 JALIKOI. All rights reserved.</p>
    </footer>
    <script>
        //fetches destinations from table destinations that start in the typed characters

         function fetchDestinations() {
        const destinationInput = document.getElementById('destination');
        const datalist = document.getElementById('destinationList');
        const term = destinationInput.value;

        if (term.length > 0) {
            fetch(`../booking_search_destinations.php?term=${encodeURIComponent(term)}`)
                .then(response => response.json())
                .then(data => {
                    datalist.innerHTML = '';
                    data.forEach(destination => {
                        const option = document.createElement('option');
                        option.value = destination;
                        datalist.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching destinations:', error));
        } else {
            datalist.innerHTML = '';
        }
    }
    </script>
</body>
</html>
