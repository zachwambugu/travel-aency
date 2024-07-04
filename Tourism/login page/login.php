<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tourism";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Store user information in session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];

            // Redirect to booking.php
            header("Location: ../booking/booking.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   
    <title>Webpage Design</title>
    <link rel="stylesheet" href="login.css">
</head>
<body background="../login page/sunset giraffe.webp">
    <div class="main">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">Jalikoi</h2>
            </div>
            <div class="menu">
                <h2 class="title">Book with Us</h2>
            </div>
            <!--<div class="search">
                <input class="srch" type="search" name="" placeholder="Type to Text">
                <a href=""><button class="btn">Search</button></a>
            </div>-->>
        </div>
        <div class="content">
            <h1>Book & <br> <span>Travel </span> <br> with us</h1>
            <p class="par">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempora praesentium 
                <br>hic sequi earum at. Quidem voluptatem sint rerum laborum, praesentium, inventore  
                <br>quod ullam, quasi optio tempora illo voluptatibus maxime amet.</p>

                <button class="cn"> <a href="../all-destinations/all-destinations.html">View all destinations</a></button>
                <div class="form">
                    <form action="../login page/login.php" method="post" >
                        <h2>Login Here</h2>
                        <input type="email"  id="email" name="email" placeholder="Enter Email here" autocomplete="0ff">
                        <input type="password" id="password" name="password" placeholder="Enter Password" autocomplete="off">
                        <button type="submit" class="btnn">Login</button>
                    </form>

                    <p class="link">Dont have an account<br>
                    <a href="../registration/registration.html">Sign Up </a>here</p>

                </div>
        </div>
    </div>
    <script>   
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
    });
    </script>
</body>
</html>