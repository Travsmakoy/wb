<?php
require_once 'conf/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $home_address = $_POST['home_address'];
    $street = $_POST['street'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];
    $zipcode = $_POST['zipcode'];
    
    // Age validation
    $dob = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($dob)->y;

    if ($age < 18) {
        $error = "You must be at least 18 years old to register.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already exists!";
        } else {
            // Handle file upload
            $target_dir = "cstmr-id/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
            }
            $target_file = $target_dir . uniqid() . '-' . basename($_FILES["identification"]["name"]);

            if (move_uploaded_file($_FILES["identification"]["tmp_name"], $target_file)) {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert user into database
                $stmt = $conn->prepare("INSERT INTO users (last_name, first_name, middle_name, birthday, identification_url, email, contact_number, password, home_address, street, province, city, municipality, barangay, zipcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('sssssssssssssss', $last_name, $first_name, $middle_name, $birthday, $target_file, $email, $contact_number, $hashed_password, $home_address, $street, $province, $city, $municipality, $barangay, $zipcode);
                $stmt->execute();
                header("Location: login.php");
                exit;
            } else {
                $error = "Failed to upload file.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(45deg, #3b3b98, #6a89cc, #38ada9, #82ccdd);
            background-size: 400% 400%;
            animation: gradient 10s ease infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .form-container {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 1100px;
            height: auto;
        }

        .form-column {
            width: 45%;
            padding: 0 1rem;
        }

        h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: #3b3b98;
        }

        label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: inline-block;
            color: #444;
        }

        input[type="text"], input[type="email"], input[type="password"], input[type="date"], input[type="file"], select {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, input[type="date"]:focus, input[type="file"]:focus, select:focus {
            border-color: #6a89cc;
            outline: none;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background-color: #3b3b98;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 1rem;
        }

        button:hover {
            background-color: #6a89cc;
        }

        .error {
            color: red;
            margin-bottom: 1rem;
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #3b3b98;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
                width: 90%;
            }

            .form-column {
                width: 100%;
                padding: 0;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<body>
    <div class="form-container">
        <div class="form-column">
            <h2>Register</h2>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <form method="post" enctype="multipart/form-data">
                <label>Last Name:</label><input type="text" name="last_name" required>
                <label>First Name:</label><input type="text" name="first_name" required>
                <label>Birthday:</label><input type="date" name="birthday" required>
                <label>Identification Upload (Valid ID):</label><input type="file" name="identification" required>
                <label>Email Address:</label><input type="email" name="email" required>
                <label>Contact Number:</label><input type="text" name="contact_number" required>
                <label>Password:</label><input type="password" name="password" required>
                <label>Confirm Password:</label><input type="password" name="confirm_password" required>
        </div>
        <div class="form-column">
                <h3>Address Details</h3>
                <label>Unit Number / House Number:</label><input type="text" name="home_address" required>
                <label>Region:</label><select name="region" id="region" required></select>
                <label>Province:</label><select name="province" id="province" required></select>
                <label>City / Municipality:</label><select name="city" id="city" required></select>
                <label>Barangay:</label><select name="barangay" id="barangay" required></select>
                <button type="submit">Register</button>
            </form>
            <a href="login.php">Already have an account? Login</a>
        </div>
    </div>

    <script src="ph-address-selector.js"></script>
</body>
</html>