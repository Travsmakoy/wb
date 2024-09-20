<?php
session_start(); // Ensure session is started
require_once 'conf/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Input validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Check if user exists
        $query = "SELECT id, email, password, is_admin FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Authentication success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $success = "Login successful! Redirecting...";
            header("Location: " . ($user['is_admin'] ? "su/dashboard.php" : "index.php"));
            exit;
        } else {
            // Authentication failed
            $error = "Invalid email or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VapeShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #333, #555);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: white;
        }
        header {
            background-color: #333;
            color: #fff;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .container {
            background: rgba(169, 169, 169, 0.9);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        img {
            width: 80%;
            height: auto;
            max-height: 80px;
            object-fit: contain;
            margin-bottom: 1rem;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            margin: 0.5rem 0;
        }
        input {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 250px;
        }
        button {
            padding: 0.5rem;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
            max-width: 250px;
        }
        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <div class="container">
        <img src="mist-logo.png" alt="Login Image">
        <h2>Login</h2>
        <form id="loginForm" method="post" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($error)) { ?>
                alert('Error: <?php echo addslashes($error); ?>');
            <?php } ?>

            <?php if (!empty($success)) { ?>
                alert('Success: <?php echo addslashes($success); ?>');
            <?php } ?>

            // Client-side validation for the form
            const form = document.getElementById('loginForm');
            form.addEventListener('submit', function(event) {
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value.trim();

                if (!email || !password) {
                    event.preventDefault(); // Prevent the form from submitting
                    alert('Please fill in all fields!');
                }
            });
        });
    </script>
</body>
</html>
