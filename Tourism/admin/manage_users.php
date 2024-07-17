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
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$message = ""; // Initialize the message variable

// Handle delete user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $message = "User deleted successfully.";
        } else {
            $message = "Error executing the statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing the statement: " . $conn->error;
    }
}

// Handle add user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    $sql = "INSERT INTO users (name, email, password, phone_number, address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $name, $email, $password, $phone_number, $address);
        if ($stmt->execute()) {
            $message = "User added successfully.";
        } else {
            $message = "Error executing the statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing the statement: " . $conn->error;
    }
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
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
            background-color: #e63946;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #b51717;
        }
        .add-user-btn {
            background-color: #2d6a4f;
            margin-bottom: 20px;
        }
        .add-user-btn:hover {
            background-color: #267300;
        }
        .form-container {
            display: none;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container.active {
            display: block;
        }
        .form-container label {
            display: block;
            margin-bottom: 10px;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
    <script>
        function toggleForm() {
            var formContainer = document.getElementById('form-container');
            formContainer.classList.toggle('active');
        }
    </script>
</head>
<body>
    <header>
        <h1>Manage Users</h1>
    </header>
    <main>
        <?php if (!empty($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <button class="add-user-btn" onclick="toggleForm()">Add User</button>
        <div id="form-container" class="form-container">
            <form method="post" action="">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" required>
                
                <label for="address">Address</label>
                <textarea id="address" name="address" required></textarea>
                
                <button type="submit" name="add_user">Add User</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                <button type="submit" name="delete_user">Delete</button>
                            </form>
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
