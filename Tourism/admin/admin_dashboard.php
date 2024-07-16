<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome to Admin Dashboard</h1>
    <nav>
        <ul>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_destinations.php">Manage Destinations</a></li>
            <li><a href="manage_bookings.php">Manage Bookings</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
