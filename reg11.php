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
    $region = $_POST['region_text'];
    $province = $_POST['province_text'];
    $city = $_POST['city_text'];
    $barangay = $_POST['barangay_text'];

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
                    mkdir($target_dir, 0777, true);
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
    <!--Finalized-->
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

    <div class="container">
        <div class="form-container mt-5">
            <div class="form-content">
                <img src="assets/mist-logo-withoutname.png" alt="Image" class="img-fluid">
                <div class="form-fields">
                    <h2 class="text-center">REGISTER</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="text" name="first_name" placeholder="First Name" id="first_name" required>
                        <input type="text" name="last_name" placeholder="Last Name" id="last_name" required>
                        <input type="date" name="birthday" id="birthday" required>
                        <input type="email" name="email" placeholder="Email" id="email" required>
                        <input type="tel" name="contact_number" placeholder="Contact Number" id="contact_number" required>
                        <input type="password" name="password" placeholder="Password" id="password" required>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" required>
                        <button type="button" onclick="nextPage()">Next</button>
                    </form>
                    <div class="bottom mt-3" id="footer">
                        <p>Already have an account?</p>
                        <a href="./login.html" class="text-white">Log-In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="./script.js">
   

</script>
</html>
