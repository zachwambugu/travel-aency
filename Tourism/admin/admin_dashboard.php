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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #d8f3dc;
        }

        header {
            background-color: #2d6a4f;
            color: #d8f3dc;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        main {
            margin-top: 70px; /* Adjust based on header height */
        }

        nav {
            background-color: #40916c;
            margin: 20px auto;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            margin: 20px 0; /* Increased spacing */
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            background-color: #2d6a4f;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
            display: inline-block;
        }

        nav ul li a:hover {
            background-color: #1e4722;
        }

        h1 {
            color: #d8f3dc;
            text-align: center;
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Admin Dashboard</h1>
    </header>
    <main>
        <nav>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_destinations.php">Manage Destinations</a></li>
                <li><a href="manage_bookings.php">Manage Bookings</a></li>
                <li><a href="admin_logout.php">Logout</a></li>
            </ul>
        </nav>
    </main>
</body>
</html>
