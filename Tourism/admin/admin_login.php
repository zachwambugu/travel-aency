<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No admin found with that email.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-decoration: none;
            background-color: #d8f3dc;
        }

        header {
            background-color: #2d6a4f;
            color: #d8f3dc;
            padding: 10px;
            text-align: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f0fff0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-container .input-group {
            margin-bottom: 20px;
            width: 100%;
        }

        .login-container .input-group p {
            margin-bottom: 5px;
            color: #2c5f2d;
        }

        .login-container .input-group input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #d8f3dc;
            border-radius: 5px;
            display: block;
            margin: 0 auto;
        }

        .login-container button {
            background-color: #2d6a4f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #1e4722;
        }

        .error {
            color: #ff4c4c;
            margin-bottom: 20px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            display: block;
            width: calc(100% - 20px);
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>
    <header>
        <h2>Admin Login</h2>
    </header>
    <div class="login-container">
        <form method="post" action="">
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="input-group">
                <p>Enter email</p>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <p>Enter password</p>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
