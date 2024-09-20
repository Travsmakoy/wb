<?php
require_once '../conf/config.php'; // Database connection

if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);
    $stmt = $conn->prepare("SELECT brand_id, brand_name FROM brands WHERE category_id = ?");
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo '<option value="">Select Brand</option>';
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['brand_id']}'>{$row['brand_name']}</option>";
    }
}
?>
