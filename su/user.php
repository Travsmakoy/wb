<?php
session_start();
require_once '../conf/config.php';

// Redirect to login if not admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}

$message = '';

// Fetch user details excluding the admin
$query = "SELECT * FROM users WHERE is_admin = 0";
$result = $conn->query($query);

// Separate users into verified and unverified
$verified_users = [];
$unverified_users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['is_verified']) {
            $verified_users[] = $row;
        } else {
            $unverified_users[] = $row;
        }
    }
}
?>
<?php if (!empty($_SESSION['message'])): ?>
    <div class="message <?php echo strpos($_SESSION['message'], 'successfully') !== false ? 'success' : 'error'; ?>">
        <?php echo htmlspecialchars($_SESSION['message']); ?>
        <?php unset($_SESSION['message']); // Clear the message after displaying ?>
    </div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #333;
            --background-color: #f4f4f4;
            --text-color: #333;
            --sidebar-width: 250px;
            --transition-time: 0.3s;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--secondary-color);
            color: #fff;
            height: 100vh;
            position: fixed;
            padding: 1rem;
            transition: width var(--transition-time);
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
            transition: background-color var(--transition-time);
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .content {
            flex:auto;
            /* flex: 1;
            padding: 2rem;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-time); */
        }

        .tabs {
            margin-top: 2rem;
            display: flex;
            border-bottom: 1px solid #ddd;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #fff;
            border: 1px solid #ddd;
            margin-right: 5px;
            transition: background-color var(--transition-time);
        }

        .tab.active {
            background-color: var(--primary-color);
            color: white;
        }

        .tab-content {
            display: none;
            opacity: 0;
            transition: opacity var(--transition-time);
        }

        .tab-content.active {
            display: block;
            opacity: 1;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 1rem;
            text-align: left;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .image-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity var(--transition-time);
        }

        .image-popup img {
            max-width: 90%;
            max-height: 90%;
            animation: zoomIn 0.3s ease-in-out;
        }

        .image-popup.show {
            display: flex;
            opacity: 1;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.7);
            }
            to {
                transform: scale(1);
            }
        }

        footer {
            margin-top: 2rem;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
<?php include "side.php" ?>
    <!-- <aside class="sidebar">
        <h2>Admin Panel</h2>
        <nav>
            <a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="../ChatUse/admin_chat"><i class="fas fa-comments"></i> Chats</a>
            <a href="user"><i class="fas fa-users"></i> Users</a>
            <a href="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside> -->

    <main class="content">
        <header class="dashboard-header">
            <h1>User Management</h1>
        </header>

        <section class="tabs">
            <div class="tab active" data-tab="unverified">Unverified Users</div>
            <div class="tab" data-tab="verified">Verified Users</div>
        </section>

        <section class="form-section">
            <div class="tab-content active" id="unverified">
                <h2>Unverified Users</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>Valid ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($unverified_users)): ?>
                            <?php foreach ($unverified_users as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['home_address'] . ', ' . $row['barangay'] . ', ' . $row['city'] . ', ' . $row['province']); ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars(str_replace('su/', '', $row['identification_url'])); ?>" 
                                             alt="Valid ID" style="width: 50px; cursor: pointer;" 
                                             onclick="showImage('<?php echo htmlspecialchars(str_replace('su/', '', $row['identification_url'])); ?>')">
                                    </td>
                                    <td>
                                        <form method="post" action="verify_user.php">
                                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                            <button type="submit" class="verify-button">Verify</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No unverified users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-content" id="verified">
                <h2>Verified Users</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>Valid ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($verified_users)): ?>
                            <?php foreach ($verified_users as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['home_address'] . ', ' . $row['barangay'] . ', ' . $row['city'] . ', ' . $row['province']); ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars(str_replace('su/', '', $row['identification_url'])); ?>" 
                                             alt="Valid ID" style="width: 50px; cursor: pointer;" 
                                             onclick="showImage('<?php echo htmlspecialchars(str_replace('su/', '', $row['identification_url'])); ?>')">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No verified users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="image-popup" id="imagePopup">
            <img id="popupImage" src="" alt="User ID">
        </div>
        
        <footer>
            &copy; 2024 Vapeshop Admin Panel. All rights reserved.
        </footer>
    </main>

    <script>
        // Tab switching functionality
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(tc => tc.classList.remove('active'));

                this.classList.add('active');
                document.getElementById(this.dataset.tab).classList.add('active');
            });
        });

        // Image modal functionality
        const popup = document.getElementById('imagePopup');
        const popupImage = document.getElementById('popupImage');

        function showImage(src) {
            popupImage.src = src;
            popup.classList.add('show');
        }

        popup.addEventListener('click', function() {
            popup.classList.remove('show');
        });
    </script>
</body>
</html>
