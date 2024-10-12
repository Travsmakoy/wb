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
<?php
// Start the session (optional)
// session_start();

// Get the requested URL
$request = $_SERVER['REQUEST_URI'];

// Remove any leading slashes
$request = ltrim($request, '/');

// Set the default file
$file = 'index.php'; // Change this to your default home page

// If the request is not empty, append .php
if (!empty($request)) {
    $file = $request . '.php';
}

// Check if the requested file exists
// if (file_exists($file)) {
//     include $file;
// } else {
//     // Handle 404 error
//     header("HTTP/1.0 404 Not Found");
//     echo "<h1>404 Not Found</h1>";
//     echo "<p>The page you are looking for does not exist.</p>";
// }
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
    <style>
        .hidden { display: none; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body> 
      <div class="container">
        <div class="form-container mt-5">
            <div class="form-content">
                <img src="assets/mist-logo-withoutname.png" alt="Image" class="img-fluid">
                <div class="form-fields">
    <h2>Register</h2>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
 
    <form method="post" enctype="multipart/form-data" id="registrationForm">
        <!-- First Page (Basic Info) -->
        <div id="page1">
            <input placeholder="First Name" type="text" name="first_name" id="first_name" required><br>
            <input placeholder="Last Name" type="text" name="last_name" id="last_name" required><br>
            <input type="date" name="birthday" id="birthday" required><br>
            <input placeholder="Email Address" type="email" name="email" id="email" required><br>
            <input placeholder="Contact Number" type="text" name="contact_number" id="contact_number" required><br>
            <input placeholder="Password" type="password" name="password" id="password" required><br>
            <input placeholder="Confirm Password" type="password" name="confirm_password" id="confirm_password" required><br>
            <button type="button" onclick="nextPage()">Next</button>
        </div>

        <!-- Second Page (Address and ID Upload) -->
        <div id="page2" class="hidden">
            <h3>Address Details</h3>
            <label>Unit Number / House Number:</label><input type="text" name="home_address" id="home_address" required><br>
            <label>Identification Upload (Valid ID):</label><input type="file" name="identification" id="identification" required><br>

            <div class="col-sm-6 mb-3">
                <label>Region *</label>
                <select name="region" class="form-control" id="region"></select>
                <input type="hidden" name="region_text" id="region-text" required>
            </div>

            <div class="col-sm-6 mb-3">
                <label>Province *</label>
                <select name="province" class="form-control" id="province"></select>
                <input type="hidden" name="province_text" id="province-text" required>
            </div>

            <div class="col-sm-6 mb-3">
                <label>City *</label>
                <select name="city" class="form-control" id="city"></select>
                <input type="hidden" name="city_text" id="city-text" required>
            </div>

            <div class="col-sm-6 mb-3">
                <label>Barangay *</label>
                <select name="barangay" class="form-control" id="barangay"></select>
                <input type="hidden" name="barangay_text" id="barangay-text" required>
            </div>

            <button type="button" onclick="prevPage()">Back</button>
            <button type="submit">Register</button>
   
    </form>
    </div>
    </div>
    </div>
    </div>
    <a href="login">Already have an account? Login</a>
  
    <script>
        function nextPage() {
            // Basic validation for page 1 fields
            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            const birthday = document.getElementById('birthday').value;
            const email = document.getElementById('email').value;
            const contactNumber = document.getElementById('contact_number').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (firstName && lastName && birthday && email && contactNumber && password && confirmPassword) {
                if (password === confirmPassword) {
                    document.getElementById('page1').classList.add('hidden');
                    document.getElementById('page2').classList.remove('hidden');
                } else {
                    alert('Passwords do not match!');
                }
            } else {
                alert('Please fill out all fields.');
            }
        }

        function prevPage() {
            document.getElementById('page2').classList.add('hidden');
            document.getElementById('page1').classList.remove('hidden');
        }

        // JavaScript for filling address fields (can be connected with `ph-address-selector.js`)
        $(document).ready(function () {
            // Simulate the address filling logic (or use the ph-address-selector.js script)
            $('#region').change(function () {
                $('#region-text').val($(this).find('option:selected').text());
            });
            $('#province').change(function () {
                $('#province-text').val($(this).find('option:selected').text());
            });
            $('#city').change(function () {
                $('#city-text').val($(this).find('option:selected').text());
            });
            $('#barangay').change(function () {
                $('#barangay-text').val($(this).find('option:selected').text());
            });
        });
    </script>
    <script src="ph-address-selector.js"></script>
</body>
</html>
