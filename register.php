<?php
require_once 'config.php';

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
</html>
