<?php
session_start();
require_once '../conf/config.php';

// Redirect to login if not admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

$message = ''; // Initialize message variable

// Handle product deletion
if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param('i', $product_id);
    if ($stmt->execute()) {
        $message = "<p class='success'>Product deleted successfully!</p>";
    } else {
        $message = "<p class='error'>Error deleting product: " . $stmt->error . "</p>";
    }
}

// Handle product update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $flavor = $_POST['flavor'];
    $color = $_POST['color'];
    $puffs = $_POST['puffs'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE products SET product_name = ?, price = ?, flavor = ?, color = ?, puffs = ?, description = ? WHERE product_id = ?");
    $stmt->bind_param('sdssisi', $product_name, $price, $flavor, $color, $puffs, $description, $product_id);

    if ($stmt->execute()) {
        $message = "<p class='success'>Product updated successfully!</p>";
    } else {
        $message = "<p class='error'>Error updating product: " . $stmt->error . "</p>";
    }
}

// Fetch all products
$result = $conn->query("SELECT * FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - VapeShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        /* Copy the styles from your dashboard.php and add/modify as needed */
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .sidebar {
            width: 250px;
            background: #333;
            color: #fff;
            padding: 20px;
            height: 100vh;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin: 15px 0;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #555;
        }
        .content {
            flex: 1;
            padding: 20px;

        }
        .success {
            color: #28a745;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
        }
        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit-form {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .edit-form input[type="text"], .edit-form input[type="number"], .edit-form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .edit-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .edit-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <!-- Sidebar (same as in dashboard.php) -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a>
        <a href="#"><i class="fas fa-comments"></i> Chats</a>
        <a href="#"><i class="fas fa-users"></i> Users</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <header>
            <h1>VapeShop - Inventory Management</h1>
        </header>

        <?php if ($message) { echo $message; } ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Flavor</th>
                    <th>Color</th>
                    <th>Puffs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['product_id']; ?></td>
                    <td><?php echo $product['product_name']; ?></td>
                    <td>$<?php echo $product['price']; ?></td>
                    <td><?php echo $product['flavor']; ?></td>
                    <td><?php echo $product['color']; ?></td>
                    <td><?php echo $product['puffs']; ?></td>
                    <td>
                        <button onclick="showEditForm(<?php echo $product['product_id']; ?>)">Edit</button>
                        <a href="?delete=<?php echo $product['product_id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div id="editForm" class="edit-form">
            <h2>Edit Product</h2>
            <form method="post">
                <input type="hidden" id="edit_product_id" name="product_id">
                <input type="hidden" name="update_product" value="1">
                
                <label for="edit_product_name">Product Name:</label>
                <input type="text" id="edit_product_name" name="product_name" required>
                
                <label for="edit_price">Price:</label>
                <input type="number" step="0.01" id="edit_price" name="price" required>
                
                <label for="edit_flavor">Flavor:</label>
                <input type="text" id="edit_flavor" name="flavor" required>
                
                <label for="edit_color">Color:</label>
                <input type="text" id="edit_color" name="color" required>
                
                <label for="edit_puffs">Puffs:</label>
                <input type="number" id="edit_puffs" name="puffs" required>
                
                <label for="edit_description">Description:</label>
                <textarea id="edit_description" name="description" rows="4" required></textarea>
                
                <button type="submit">Update Product</button>
            </form>
        </div>

        <footer>
            <p>&copy; 2024 VapeShop - Inventory Management</p>
        </footer>
    </div>

    <script>
    function showEditForm(productId) {
        // Fetch product details and populate the form
        fetch(`get_product.php?id=${productId}`)
            .then(response => response.json())
            .then(product => {
                document.getElementById('edit_product_id').value = product.product_id;
                document.getElementById('edit_product_name').value = product.product_name;
                document.getElementById('edit_price').value = product.price;
                document.getElementById('edit_flavor').value = product.flavor;
                document.getElementById('edit_color').value = product.color;
                document.getElementById('edit_puffs').value = product.puffs;
                document.getElementById('edit_description').value = product.description;
                
                document.getElementById('editForm').style.display = 'block';
            });
    }
    </script>
</body>
</html>