<?php
session_start();
require_once '../conf/config.php';

// Redirect to login if not admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

$message = ''; // Initialize message variable

// Handle new product submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $category_id = $_POST['category_id'];
    $brand_id = $_POST['brand_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $flavor = $_POST['flavor'];
    $color = $_POST['color'];
    $puffs = $_POST['puffs'];
    $description = $_POST['description'];

    // Handle file upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert product into the database
        $stmt = $conn->prepare("INSERT INTO products (category_id, brand_id, product_name, price, flavor, color, puffs, description, img_dir) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('iisdssiss', $category_id, $brand_id, $product_name, $price, $flavor, $color, $puffs, $description, $target_file);

        if ($stmt->execute()) {
            $message = "Product added successfully!";
        } else {
            $message = "Error adding product: " . $stmt->error;
        }
    } else {
        $message = "Error uploading image.";
    }
}

// Handle new category submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $new_category = $_POST['new_category'];
    
    // Insert new category into the database
    $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
    $stmt->bind_param('s', $new_category);

    if ($stmt->execute()) {
        $message = "Category added successfully!";
    } else {
        $message = "Error adding category: " . $stmt->error;
    }
}

// Handle new brand submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_brand'])) {
    $category_id = $_POST['category_id'];
    $new_brand = $_POST['new_brand'];
    
    // Insert new brand into the database
    $stmt = $conn->prepare("INSERT INTO brands (brand_name, category_id) VALUES (?, ?)");
    $stmt->bind_param('si', $new_brand, $category_id);

    if ($stmt->execute()) {
        $message = "Brand added successfully!";
    } else {
        $message = "Error adding brand: " . $stmt->error;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #333;
            --background-color: #f4f4f4;
            --text-color: #333;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--secondary-color);
            color: #fff;
            padding: 2rem;
            height: 100vh;
            position: fixed;
        }

        .sidebar h2 {
            margin-bottom: 2rem;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin: 1rem 0;
            padding: 0.75rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .content {
            flex: 1;
            padding: 2rem;
            margin-left: var(--sidebar-width);
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .message {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .form-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        footer {
            margin-top: 2rem;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>Admin Panel</h2>
        <nav>
            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a>
            <a href="#"><i class="fas fa-comments"></i> Chats</a>
            <a href="#"><i class="fas fa-users"></i> Users</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="content">
        <header class="dashboard-header">
            <h1>VapeShop - Admin Dashboard</h1>
        </header>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <section class="form-section">
            <h2>Add New Product</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="add_product">

                <div class="form-group">
                    <label for="category_id">Category:</label>
                    <select id="category_id" name="category_id" required onchange="loadBrands(this.value)">
                        <option value="">Select Category</option>
                        <?php
                        $categories = $conn->query("SELECT category_id, category_name FROM categories");
                        while ($row = $categories->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['category_id']) . "'>" . htmlspecialchars($row['category_name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="brand_id">Brand:</label>
                    <select id="brand_id" name="brand_id" required>
                        <option value="">Select Brand</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="product_name">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" required>
                </div>

                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" required>
                </div>

                <div class="form-group">
                    <label for="flavor">Flavor:</label>
                    <input type="text" id="flavor" name="flavor" required>
                </div>

                <div class="form-group">
                    <label for="color">Color:</label>
                    <input type="text" id="color" name="color" required>
                </div>

                <div class="form-group">
                    <label for="puffs">Puffs:</label>
                    <input type="number" id="puffs" name="puffs" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>

                <button type="submit">Add Product</button>
            </form>
        </section>

        <section class="form-section">
            <h2>Add New Category</h2>
            <form method="post">
                <input type="hidden" name="add_category">
                <div class="form-group">
                    <label for="new_category">New Category Name:</label>
                    <input type="text" id="new_category" name="new_category" required>
                </div>
                <button type="submit">Add Category</button>
            </form>
        </section>

        <section class="form-section">
            <h2>Add New Brand for Category</h2>
            <form method="post">
                <input type="hidden" name="add_brand">
                <div class="form-group">
                    <label for="category_id_brand">Category:</label>
                    <select id="category_id_brand" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php
                        $categories = $conn->query("SELECT category_id, category_name FROM categories");
                        while ($row = $categories->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['category_id']) . "'>" . htmlspecialchars($row['category_name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="new_brand">New Brand Name:</label>
                    <input type="text" id="new_brand" name="new_brand" required>
                </div>
                <button type="submit">Add Brand</button>
            </form>
        </section>

        <footer>
            <p>&copy; 2024 VapeShop - Admin Dashboard</p>
        </footer>
    </main>
    
    <script>
    function loadBrands(categoryId) {
        if (categoryId) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_brands.php?category_id=' + encodeURIComponent(categoryId), true);
            xhr.onload = function () {
                if (this.status === 200) {
                    document.getElementById('brand_id').innerHTML = this.responseText;
                }
            };
            xhr.send();
        } else {
            document.getElementById('brand_id').innerHTML = '<option value="">Select Brand</option>';
        }
    }
    </script>
</body>
</html>