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
            background-color: #1a1b26;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: white;
        }
        .container {
            background-color: #24273a;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #8be9fd;
            margin-bottom: 2rem;
        }
        .logo {
            display: block;
            margin: 0 auto 2rem;
            width: 120px;
            height: 120px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            background-color: #1f2b46;
            color: #ffffff;
            font-size: 1rem;
        }
        input::placeholder {
            color: #a0a0a0;
        }
        button {
            background: linear-gradient(to right, #0fadf2, #ff00ff);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            text-transform: uppercase;
            transition: opacity 0.3s ease;
        }
        button:hover {
            opacity: 0.9;
        }
        .register-link {
            text-align: center;
            margin-top: 1rem;
            color: #a0a0a0;
        }
        .register-link a {
            color: #0fadf2;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="mist-logo.png" alt="Vape Shop Logo" class="logo">
        <form id="loginForm" method="post" action="login.php">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">LOGIN</button>
        </form>
        <p class="register-link">Don't have an account? <a href="register.php">Register</a></p>
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
