<?php
session_start();
require_once '../conf/config.php';

// Redirect to login if not admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

$message = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'];
    $brand = $_POST['brand'];
    $flavor = $_POST['flavor'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert product into database
        $stmt = $conn->prepare("INSERT INTO products (category_id, brand, flavor, title, description, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isssss', $category_id, $brand, $flavor, $title, $description, $target_file);

        if ($stmt->execute()) {
            $message = "<p class='success'>Product added successfully!</p>";
        } else {
            $message = "<p class='error'>Error adding product: " . $stmt->error . "</p>";
        }
    } else {
        $message = "<p class='error'>Error uploading image.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - VapeShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-dYp7zlKNFTePaRHsPGAu6L0waVHglnosXCVc+npfb+5FfYPojCwt8kdnSxx7qJ7gxuP47wnSaKvN6bV6gtCQNg==" crossorigin="anonymous" />
    <style>
        :root {
            --primary-bg: #0a0b1e;
            --secondary-bg: #141836;
            --accent-pink: #ff00ff;
            --accent-blue: #00ffff;
            --text-light: #ffffff;
            --text-muted: #a0a0a0;
        }

        /* Global styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-light);
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--secondary-bg);
            padding-top: 20px;
            color: var(--text-light);
        }

        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: var(--text-light);
            display: block;
            margin-bottom: 10px;
            transition: background-color 0.3s ease, border-left 0.3s ease;
        }

        .sidebar a:hover {
            background-color: rgba(255, 0, 255, 0.1);
            border-left: 5px solid var(--accent-pink);
        }

        .sidebar i {
            margin-right: 10px;
        }

        /* Content */
        .content {
            margin-left: 250px;
            padding: 20px;
        }

        header {
            background-color: var(--accent-blue);
            color: var(--text-light);
            padding: 10px;
            text-align: center;
            position: sticky;
            top: 0;
            box-shadow: 0 0 10px var(--accent-blue);
        }

        .container {
            background-color: var(--secondary-bg);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 255, 255, 0.2);
        }

        h2 {
            color: var(--accent-blue);
            font-family: 'Orbitron', sans-serif;
            margin-bottom: 1.5rem;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 0.5rem;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid var(--accent-blue);
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-light);
            border-radius: 5px;
        }

        input[type="file"] {
            padding: 5px;
        }

        button {
            padding: 10px 15px;
            background-color: var(--accent-pink);
            color: var(--text-light);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff33ff;
        }

        .success {
            color: var(--accent-blue);
        }

        .error {
            color: var(--accent-pink);
        }

        /* Footer */
        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .sidebar a {
                float: left;
            }

            .content {
                margin-left: 0;
            }

            header {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#"><i class="fas fa-boxes"></i> Products</a>
        <a href="#"><i class="fas fa-comments"></i> Chats</a>
        <a href="#"><i class="fas fa-users"></i> Users</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <header>
            <h1>VapeShop - Admin Dashboard</h1>
        </header>

        <div class="container">
            <h2>Add New Product</h2>
            <?php if ($message) { echo $message; } ?>
            <form method="post" enctype="multipart/form-data">
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required>
                    <?php
                    $categories = $conn->query("SELECT id, name FROM categories");
                    while ($row = $categories->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>

                <label for="brand">Brand:</label>
                <input type="text" id="brand" name="brand" required>

                <label for="flavor">Flavor:</label>
                <input type="text" id="flavor" name="flavor" required>

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <button type="submit">Add Product</button>
            </form>
        </div>

        <footer>
            <p>&copy; 2024 VapeShop - Admin Dashboard</p>
        </footer>
    </div>
    
</body>
</html>
