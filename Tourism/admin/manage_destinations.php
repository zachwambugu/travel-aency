<?php
session_start();
include('config.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_destination'])) {
    $destination_id = $_POST['destination_id'];
    $sql = "DELETE FROM destinations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $destination_id);
    $stmt->execute();
    $stmt->close();
}

$sql = "SELECT * FROM destinations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Destinations</title>
</head>
<body>
    <h1>Manage Destinations</h1>
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
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="destination_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_destination">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
