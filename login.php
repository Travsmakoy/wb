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
<?php include './navbar.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innocous Mist | Login</title>
    <link rel="stylesheet" href="./styles/output.css">
    <link rel="stylesheet" href="./styles/home.css">
    <link rel="shortcut icon" href="./assets/Favicon_Retro.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Your existing CSS styles */
        body {
            background-color: #1A1D3B;
            font-family: 'Poppins', sans-serif;
        }

        #loginPopup {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        .login-container {
            background-color: #2A2D4B;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 400px;
        }

        .login-container h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(90deg, rgba(51, 252, 255, 1) 30%, rgba(255, 0, 138, 1) 71%, rgba(255, 80, 176, 1) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .input-field {
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .input-field label {
            display: block;
            margin-bottom: 0.5rem;
            color: #33FCFF;
        }

        .input-field input {
            width: 100%;
            padding: 10px;
            border: 2px solid #33FCFF;
            border-radius: 5px;
            background-color: #1A1D3B;
            color: #ffffff;
        }

        .input-field input:focus {
            outline: none;
            border-color: #FF1695;
        }

        .submit-button {
            background: linear-gradient(to bottom, #FF1695, #008F99);
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }

        .register-link {
            text-align: center;
            margin-top: 1rem;
            color: #FF1695;
        }
    </style>
</head>

<body>
    <!-- NAVIGATION -->

    <div id="loginPopup">
        <div class="login-container">
            <div class="flex items-center justify-center mb-4">
                <img src="assets/mist-logo-withoutname.png" alt="Logo" style="max-width: 100px;">
            </div>
            <h1 class="retro_clouds_h1 uppercase font-bold text-2xl text-center">LOG IN</h1>

            <div class="error-message">
                <!-- <span><?php echo $systemMessage; ?></span> -->
                <ul>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($errors)) :
                        foreach ($errors as $error) :
                    ?>
                            <li><?php echo $error; ?></li>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>

            <form method="post" id="loginForm">
                <div class="input-field">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>

                <div class="input-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" name="loginBtn" class="submit-button">LOGIN</button>

                <div class="register-link">
                    <p>Don't have an account? <a href="register" style="color: #33FCFF;">Register</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/d870978cd1.js" crossorigin="anonymous"></script>
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
