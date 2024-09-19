<?php
session_start(); // Ensure session is started
require_once 'conf/config.php';

$error = '';

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

            if ($user['is_admin']) {
                header("Location: su/dashboard.php"); // Redirect to admin dashboard
            } else {
                header("Location: index.php"); // Redirect to user page
            }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.15/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(-45deg, #6a11cb, #2575fc, #6a11cb, #2575fc);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 0.5rem 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: auto;
        }
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }
        .menu-toggle span {
            background: #fff;
            height: 3px;
            width: 25px;
            margin: 3px 0;
            transition: 0.3s;
        }
        #navbar {
            display: flex;
            align-items: center;
        }
        #navbar a {
            color: #fff;
            padding: 0.5rem 1rem;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        #navbar a:hover {
            background-color: #555;
        }
        .container {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 1rem;
            position: relative;
            margin-top: 4rem; /* Adjust for fixed header */
        }
        .container img {
            width: 100%;
            height: auto;
            max-height: 150px;
            object-fit: contain;
            margin-bottom: 1rem;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 0.5rem 0;
        }
        input {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 0.5rem;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #555;
        }
        .error {
            color: red;
            margin-bottom: 1rem;
        }
        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }
            #navbar {
                display: none;
                flex-direction: column;
                width: 100%;
                background-color: #333;
                position: absolute;
                top: 60px; /* Adjust based on header height */
                left: 0;
                z-index: 1000;
            }
            #navbar.active {
                display: flex;
            }
            #navbar a {
                padding: 1rem;
                text-align: center;
                border-bottom: 1px solid #555;
            }
            #navbar a:last-child {
                border-bottom: none;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.15/sweetalert2.all.min.js"></script>
</head>
<body>
    <header>
        <?php include 'navbar.php'; // Include the navigation bar ?>
    </header>
    <div class="container">
        <img src="mist-logo.png" alt="Login Image"> <!-- Replace with your image -->
        <h2>Login</h2>
        <form method="post" action="login.php">
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
            <?php if (isset($error) && !empty($error)) { ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo $error; ?>'
                });
            <?php } ?>
        });
    </script>
</body>
</html>
