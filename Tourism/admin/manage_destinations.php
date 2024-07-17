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

// Handle delete destination
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_destination'])) {
    $destination_id = $_POST['destination_id'];
    $sql = "DELETE FROM destinations WHERE destination_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $destination_id);
        if ($stmt->execute()) {
            $message = "Destination deleted successfully.";
        } else {
            $message = "Error executing the statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing the statement: " . $conn->error;
    }
}

// Handle add destination
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_destination'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image_path = $_POST['image_path'];
    $location = $_POST['location'];
    $distance = $_POST['distance'];
    $towns = $_POST['towns'];
    $cost = $_POST['cost'];

    $sql = "INSERT INTO destinations (name, description, image_path, location, distance, towns, cost) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssisi", $name, $description, $image_path, $location, $distance, $towns, $cost);
        if ($stmt->execute()) {
            $message = "Destination added successfully.";
        } else {
            $message = "Error executing the statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing the statement: " . $conn->error;
    }
}

$sql = "SELECT * FROM destinations";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Destinations</title>
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
        .add-destination-btn {
            background-color: #2d6a4f;
            margin-bottom: 20px;
        }
        .add-destination-btn:hover {
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
        .form-container input[type="number"],
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
        <h1>Manage Destinations</h1>
    </header>
    <main>
        <?php if (!empty($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <button class="add-destination-btn" onclick="toggleForm()">Add Destination</button>
        <div id="form-container" class="form-container">
            <form method="post" action="">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
                
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
                
                <label for="image_path">Image Path</label>
                <input type="text" id="image_path" name="image_path" required>
                
                <label for="location">Location</label>
                <input type="text" id="location" name="location" required>
                
                <label for="distance">Distance</label>
                <input type="number" id="distance" name="distance" step="0.1" required>
                
                <label for="towns">Towns</label>
                <textarea id="towns" name="towns" required></textarea>
                
                <label for="cost">Cost</label>
                <input type="number" id="cost" name="cost" required>
                
                <button type="submit" name="add_destination">Add Destination</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['destination_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="destination_id" value="<?php echo $row['destination_id']; ?>">
                                <button type="submit" name="delete_destination">Delete</button>
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
