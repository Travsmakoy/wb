<?php
session_start();
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session
header("Location: index.php"); // Redirect to login page
exit;
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