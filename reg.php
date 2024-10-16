<?php
require_once 'conf/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $home_address = $_POST['home_address'];
    $region = $_POST['region_text']; // Use text field instead of the select value
    $province = $_POST['province_text']; // Use text field instead of the select value
    $city = $_POST['city_text']; // Use text field instead of the select value
    $barangay = $_POST['barangay_text']; // Use text field instead of the select value
    
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
            // Check if contact number already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE contact_number = ?");
            $stmt->bind_param('s', $contact_number);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Contact number already exists!";
            } else {
                // Handle file upload
                $target_dir = "su/cstmr-id/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
                }
                $target_file = $target_dir . uniqid() . '-' . basename($_FILES["identification"]["name"]);

                if (move_uploaded_file($_FILES["identification"]["tmp_name"], $target_file)) {
                    // Hash password
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                    // Insert user into database
                    $stmt = $conn->prepare("INSERT INTO users (last_name, first_name, birthday, identification_url, email, contact_number, password, home_address, region, province, city, barangay) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('ssssssssssss', $last_name, $first_name, $birthday, $target_file, $email, $contact_number, $hashed_password, $home_address, $region, $province, $city, $barangay);
                    $stmt->execute();
                    header("Location: login.php");
                    exit;
                } else {
                    $error = "Failed to upload file.";
                }
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins|Kanit|Space+Grotesk">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Register</title>
</head>
<body>
    
    <h2>Register</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form method="post" enctype="multipart/form-data">
        <label>First Name:</label><input type="text" name="first_name" required><br>
        <label>Last Name:</label><input type="text" name="last_name" required><br>
        <label>Birthday:</label><input type="date" name="birthday" required><br>
        <label>Identification Upload (Valid ID):</label><input type="file" name="identification" required><br>
        <label>Email Address:</label><input type="email" name="email" required><br>
        <label>Contact Number:</label><input type="text" name="contact_number" required><br>
        <label>Password:</label><input type="password" name="password" required><br>
        <label>Confirm Password:</label><input type="password" name="confirm_password" required><br>
        <h3>Address Details</h3>
        <label>Unit Number / House Number:</label><input type="text" name="home_address" required>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Region *</label>
            <select name="region" class="form-control form-control-md" id="region"></select>
            <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Province *</label>
            <select name="province" class="form-control form-control-md" id="province"></select>
            <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">City *</label>
            <select name="city" class="form-control form-control-md" id="city"></select>
            <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Barangay *</label>
            <select name="barangay" class="form-control form-control-md" id="barangay"></select>
            <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>
        </div>

        <button type="submit">Register</button>
    </form>
    <a href="login.php">Already have an account? Login</a>
</body>
<script src="ph-address-selector.js"></script>
</html>
