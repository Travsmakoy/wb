<?php
session_start();
require_once 'conf/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        $query = "SELECT id, email, password, is_admin FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $success = "Login successful! Redirecting...";
            header("Location: " . ($user['is_admin'] ? "su/dashboard.php" : "index.php"));
            exit;
        } else {
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1a1b26, #24273a);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .nav-placeholder {
            /* Adjust as needed */
            background-color: rgba(36, 39, 58, 0.8);
            padding: 1rem;
        }
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .footer-placeholder {
            /* Adjust as needed */
            background-color: rgba(36, 39, 58, 0.8);
            padding: 1rem;
            text-align: center;
        }
        .container {
            background-color: rgba(36, 39, 58, 0.8);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
        }
        h1 {
            text-align: center;
            color: #8be9fd;
            margin-bottom: 2rem;
            font-weight: 600;
        }
        .logo {
            display: block;
            margin: 0 auto 2rem;
            width: 120px;
            height: 120px;
            transition: transform 0.3s ease;
        }
        .logo:hover {
            transform: scale(1.05);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        input {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            background-color: #1f2b46;
            color: #ffffff;
            font-size: 1rem;
            transition: box-shadow 0.3s ease;
        }
        input:focus {
            outline: none;
            box-shadow: 0 0 0 2px #0fadf2;
        }
        input::placeholder {
            color: #a0a0a0;
        }
        button {
            background: linear-gradient(to right, #0fadf2, #ff00ff);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 173, 242, 0.4);
        }
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #a0a0a0;
        }
        .register-link a {
            color: #0fadf2;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .register-link a:hover {
            color: #ff00ff;
        }
        .message {
            text-align: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-radius: 4px;
        }
        .error {
            background-color: rgba(255, 0, 0, 0.1);
            color: #ff6b6b;
        }
        .success {
            background-color: rgba(0, 255, 0, 0.1);
            color: #51cf66;
        }
    </style>
</head>
<body>
    <div class="nav-placeholder">
        <?php include './navbar.php'; ?>
    </div>

    <div class="main-content">
        <div class="container">
            <img src="assets/mist-logo-withoutname.png" alt="Vape Shop Logo" class="logo">
            <!-- <h1>Welcome Back</h1> -->
            <?php if (!empty($error)): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="message success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form id="loginForm" method="post" action="login.php">
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p class="register-link">Don't have an account? <a href="register">Register</a></p>
        </div>
    </div>

    <div class="footer-placeholder">
        <?php include 'conf/foot.php'; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            form.addEventListener('submit', function(event) {
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value.trim();

                if (!email || !password) {
                    event.preventDefault();
                    alert('Please fill in all fields!');
                }
            });
        });
    </script>
</body>
</html>