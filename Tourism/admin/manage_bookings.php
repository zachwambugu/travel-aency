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
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$message = ""; // Initialize the message variable

// Handle approve or reject booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    if (isset($_POST['approve_booking'])) {
        $sql = "UPDATE bookings SET status = 'approved' WHERE booking_id = ?";
    } elseif (isset($_POST['reject_booking'])) {
        $sql = "UPDATE bookings SET status = 'rejected' WHERE booking_id = ?";
    }
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $booking_id);
        if ($stmt->execute()) {
            $message = "Booking status updated successfully.";
        } else {
            $message = "Error executing the statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing the statement: " . $conn->error;
    }
}

$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #d8f3dc;
        }
        header {
            background-color: #2d6a4f;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            margin: 0;
            color: #d8f3dc;
        }
        main {
            margin: 20px;
        }
        h1 {
            color: #2d6a4f;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #2d6a4f;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        button {
            background-color: #2d6a4f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #1b4d3e;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Bookings</h1>
    </header>
    <main>
        <?php if (!empty($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Destination ID</th>
                    <th>Date</th>
                    <th>People</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['destination_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['people']); ?></td>
                        <td><?php echo htmlspecialchars($row['payment']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <div class="actions">
                                <form method="post" action="">
                                    <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                    <button type="submit" name="approve_booking">Approve</button>
                                    <button type="submit" name="reject_booking">Reject</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>

<?php
$conn->close();
?>
