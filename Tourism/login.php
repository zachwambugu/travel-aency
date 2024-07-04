<!-- <?php
//session_start();

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $servername = "localhost";
//     $username = "root";
//     $password = "";
//     $dbname = "tourism";

//     // Create connection
//     $conn = new mysqli($servername, $username, $password, $dbname);

//     // Check connection
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     $sql = "SELECT * FROM users WHERE email = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("s", $email);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         if (password_verify($password, $row['password'])) {
//             // Store user information in session variables
//             $_SESSION['user_id'] = $row['id'];
//             $_SESSION['user_name'] = $row['name'];
//             $_SESSION['user_email'] = $row['email'];

//             // Redirect to booking.php
//             header("Location: booking.php");
//             exit();
//         } else {
//             echo "Invalid password.";
//         }
//     } else {
//         echo "No user found with that email.";
//     }

//     $stmt->close();
//     $conn->close();
//}
?> 
