<?php
session_start();
require_once '../includes/db_connection.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to add items to wishlist']);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['product_id']) || !isset($data['price'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$data['product_id'];
$price = (float)$data['price'];
$image_url = isset($data['image_url']) ? $data['image_url'] : null;

// Detect if 'toys' table exists and set product_table accordingly
$table_check = $conn->query("SHOW TABLES LIKE 'toys'");
$product_table = ($table_check->num_rows > 0) ? 'toys' : 'products';

// Replace product existence check to use correct table
$stmt = $conn->prepare("SELECT id FROM {$product_table} WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
    exit();
}

// Check if item already exists in wishlist
$stmt = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Item already in wishlist']);
    exit();
}

// Add item to wishlist
$stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id, price, image_url) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iids", $user_id, $product_id, $price, $image_url);

if ($stmt->execute()) {
    // Get updated wishlist count
    $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM wishlist WHERE user_id = ?");
    $count_stmt->bind_param("i", $user_id);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $wishlist_count = $count_result->fetch_assoc()['total'] ?? 0;
    
    echo json_encode([
        'success' => true, 
        'message' => 'Item added to wishlist successfully',
        'wishlist_count' => $wishlist_count
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error adding item to wishlist']);
}

$stmt->close();
$conn->close();
?> 