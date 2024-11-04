<!-- navbar.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session only if it hasn't been started
}
require_once 'conf/config.php';

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
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

<header class="head">
    <link rel="stylesheet" href="styles/global.css">
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <a href="index" style="display: flex; align-items: center; text-decoration: none;">
                    <img src="assets/logo.png" alt="Innocuous Mist" class="navbar-logo">
                    <!-- <span class="navbar-brand">Innocuous Mist</span> -->
                </a>
            </div>
            <ul class="nav-menu">
    <li><a href="index" class="nav-link">HOME</a></li>
    <!-- <li><a href="ChatUse/customer_chat.php" class="nav-link">CHAT</a></li> -->
    <li><a href="catalog" class="nav-link">CATALOG</a></li>
    <li class="dropdown">
        <a href="#" class="nav-link dropdown-toggle">OTHERS</a>
        <ul class="dropdown-menu">
            <li><a href="#" class="nav-link">FAQs</a></li>
            <li><a href="#" class="nav-link">About Us</a></li>
            <li><a href="#" class="nav-link">Others</a></li>
        </ul>
    </li>
    
    <li>
        <?php if ($is_logged_in): ?>
            <a href="logout" class="btn btn-login">LOGOUT</a>
        <?php else: ?>
            <a href="login" class="btn btn-login">LOGIN</a>
        <?php endif; ?>
    </li>
</ul>

            <button class="hamburger" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
</header>

<style>
    /* Additional custom styles for the navbar */
    /* Style for the dropdown */
.nav-menu .dropdown {
    position: relative;
    display: inline-block;
}

.nav-menu .dropdown-menu {
    display: none;
    position: absolute;
    background-color: #fff;
    min-width: 160px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    list-style-type: none;
    padding: 0;
}

.nav-menu .dropdown-menu li {
    padding: 12px 16px;
}

.nav-menu .dropdown-menu li a {
    color: #000;
    text-decoration: none;
    display: block;
}

.nav-menu .dropdown-menu li a:hover {
    background-color: #f1f1f1;
}

.nav-menu .dropdown:hover .dropdown-menu {
    display: block;
}

    .navbar {
        display:  fixed;
        background-color: var(--primary-bg);
        padding: 10px 0;
        box-shadow: 0 2px 10px rgba(0, 255, 255, 0.1);
    }

    .navbar-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 2rem;
        max-width: 1200px;
        margin: 0 auto;
        height: auto;
    }

    /* Logo Styles */
    .navbar-logo {
        padding-top: 23px;
        height: 40px; /* Adjust the height for better visibility */
        width: auto; 
        margin-right: 10px;
        
    }

    .logo a {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--accent-blue);
        text-transform: uppercase;
        white-space: nowrap; /* Prevents breaking into multiple lines */
    }

    .nav-menu {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-menu li {
        margin-left: 1.5rem;
    }

    .nav-link {
        color: var(--text-light);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: bold;
        letter-spacing: 1px;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: var(--accent-pink);
    }

    .btn-login {
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: bold;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .navbar-container {
            flex-wrap: wrap;
            padding: 0 1rem; /* Reduce padding for mobile */
        }

        .navbar-logo {
            height: 50px; /* Smaller height for mobile */
        }

        .navbar-brand {
            font-size: 1.2rem; /* Adjust font size for mobile */
        }

        .nav-link {
            font-size: 0.8rem; /* Adjust font size for mobile */
        }

        .btn-login {
            padding: 6px 15px; /* Adjust padding for mobile */
            font-size: 0.8rem; /* Adjust font size for mobile */
        }

        .nav-menu {
            display: none; /* Hidden by default */
            flex-direction: column;
            width: 100%;
            margin-top: 1rem;
            background-color: var(--primary-bg); /* Match navbar background */
            position: absolute; /* Position it absolutely */
            top: 60px; /* Position below the navbar */
            left: 0;
            z-index: 1000; /* Ensure it overlays other content */
            padding: 16px;
            /* height: 50vh; */
        }

        .nav-menu.active {
            display: flex; /* Show when active */
            flex-direction: column;
            gap: 16px;
        }

        .hamburger {
            display: block; /* Show hamburger only in mobile view */
            cursor: pointer;
            border: none; /* Remove border */
            background: none; /* Remove background */
            outline: none; /* Remove outline */
        }
    }

    /* Hide hamburger in desktop view */
    @media (min-width: 769px) {
        .hamburger {
            display: none; /* Hide hamburger */
        }
    }

    /* Hamburger styles */
    .hamburger span {
        display: block;
        width: 25px;
        height: 3px;
        margin: 4px auto;
        background-color: var(--text-light); /* Match text color */
        transition: all 0.3s ease;
    }

    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0; /* Hide the middle bar */
    }

    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('.nav-menu');

        hamburger.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            hamburger.classList.toggle('active');
            hamburger.setAttribute('aria-expanded', hamburger.classList.contains('active'));
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = navMenu.contains(event.target) || hamburger.contains(event.target);
            if (!isClickInside && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
                hamburger.setAttribute('aria-expanded', 'false');
            }
        });

        // Close menu when window is resized above mobile breakpoint
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
                hamburger.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>
