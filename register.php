<?php
session_start();
require_once 'conf/config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['next'])) {
        // Save page 1 data to session
        $_SESSION['first_name'] = $_POST['first_name'];
        $_SESSION['last_name'] = $_POST['last_name'];
        $_SESSION['birthday'] = $_POST['birthday'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['contact_number'] = $_POST['contact_number'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['confirm_password'] = $_POST['confirm_password'];
        $_SESSION['identification'] = $_FILES['identification'];
        // Move to page 2
        $step = 2;
    } elseif (isset($_POST['submit'])) {
        // Validate and process page 2 data
        $home_address = $_POST['home_address'];
        $street = $_POST['street'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $municipality = $_POST['municipality'];
        $barangay = $_POST['barangay'];
        $zipcode = $_POST['zipcode'];

        $password = $_SESSION['password'];
        $confirm_password = $_SESSION['confirm_password'];
        $email = $_SESSION['email'];

        // Age validation
        $dob = new DateTime($_SESSION['birthday']);
        $today = new DateTime();
        $age = $today->diff($dob)->y;

        if ($age < 18) {
            $error = "You must be at least 18 years old to register.";
            $step = 1;
        } elseif ($password !== $confirm_password) {
            $error = "Passwords do not match!";
            $step = 1;
        } else {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Email already exists!";
                $step = 1;
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
                    $stmt = $conn->prepare("INSERT INTO users (last_name, first_name, birthday, identification_url, email, contact_number, password, home_address, street, province, city, municipality, barangay, zipcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('ssssssssssssss', $_SESSION['last_name'], $_SESSION['first_name'], $_SESSION['birthday'], $target_file, $email, $_SESSION['contact_number'], $hashed_password, $home_address, $street, $province, $city, $municipality, $barangay, $zipcode);
                    $stmt->execute();
                    session_unset();
                    session_destroy();
                    header("Location: login.php");
                    exit;
                } else {
                    $error = "Failed to upload file.";
                    $step = 1;
                }
            }
        }
    }
} else {
    // Start at page 1
    $step = 1;
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
        * { box-sizing: border-box; }
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
        .form-left {
            flex: 1;
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-left img {
            max-width: 100%;
            height: auto;
        }
        .form-right {
            flex: 1;
            padding: 1rem;
        }
        h2 {
            text-align: center;
            color: #3b3b98;
        }
        label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            color: #444;
        }
        input, select {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border 0.3s ease;
        }
        input:focus, select:focus {
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
            cursor: pointer;
            transition: background 0.3s ease;
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
        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
                width: 90%;
            }
            .form-left, .form-right {
                width: 100%;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <?php if ($step == 1): ?>
            <div class="form-left">
                <img src="mist-logo.png" alt="Logo">
            </div>
            <div class="form-right">
                <h2>Register - Step 1</h2>
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
                    <button type="submit" name="next">Next</button>
                </form>
                <a href="login.php">Already have an account? Login</a>
            </div>
        <?php elseif ($step == 2): ?>
            <div class="form-left">
                <img src="mist-logo.png" alt="Logo">
            </div>
            <div class="form-right">
                <h2>Register - Step 2</h2>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
                <form method="post">
                    <label>Unit Number / House Number:</label><input type="text" name="home_address" required>
                    <label>Street:</label><input type="text" name="street" required>
                    <label>Region:</label><select name="region" id="region" required></select>
                    <label>Province:</label><select name="province" id="province" required></select>
                    <label>City / Municipality:</label><select name="city" id="city" required></select>
                    <label>Barangay:</label><select name="barangay" id="barangay" required></select>
                    <button type="submit" name="submit">Submit</button>
                </form>
                <a href="login.php">Already have an account? Login</a>
            </div>
        <?php endif; ?>
    </div>
    <script src="ph-address-selector.js"></script>
</body>
</html>


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
            $target_dir = "uploads/";
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
<!-- This is working Registration -->
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form method="post" enctype="multipart/form-data">
        <label>Last Name:</label><input type="text" name="last_name" required><br>
        <label>First Name:</label><input type="text" name="first_name" required><br>
        <!-- <label>Middle Name (Optional):</label><input type="text" name="middle_name"><br> -->
        <label>Birthday:</label><input type="date" name="birthday" required><br>
        <label>Identification Upload (Valid ID):</label><input type="file" name="identification" required><br>
        <label>Email Address:</label><input type="email" name="email" required><br>
        <label>Contact Number:</label><input type="text" name="contact_number" required><br>
        <label>Password:</label><input type="password" name="password" required><br>
        <label>Confirm Password:</label><input type="password" name="confirm_password" required><br>
        <!-- <label>Unit Number / House Number:</label><input type="text" name="home_address" required><br>
        <label>Street:</label><input type="text" name="street" required><br>
        <label>Province:</label><input type="text" name="province" required><br>
        <label>City:</label><input type="text" name="city" required><br>
        <label>Municipality:</label><input type="text" name="municipality" required><br>
        <label>Barangay:</label><input type="text" name="barangay" required><br> -->
        <!-- <label>Zipcode:</label><input type="text" name="zipcode" required><br> -->
        <h3>Address Details</h3>
        <label>Unit Number / House Number:</label><input number="text" name="home_address" required>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Region *</label>
            <select name="street" class="form-control form-control-md" id="region"></select>
            <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Province *</label>
            <select name="province" class="form-control form-control-md" id="province"></select>
            <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">City / Municipality *</label>
            <select name="city" class="form-control form-control-md" id="city"></select>
            <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Barangay *</label>
            <select name="barangay" class="form-control form-control-md" id="barangay"></select>
            <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>
        </div>

        <div class="col-md-6">

        </div>

        <button type="submit">Register</button>
    </form>
    <a href="login.php">Already have an account? Login</a>
</body>
<script src="ph-address-selector.js"></script>
</html> -->