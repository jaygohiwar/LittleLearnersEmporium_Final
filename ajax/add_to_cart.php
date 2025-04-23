<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db_connection.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to add items to cart']);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['product_id']) || !isset($data['price']) || !isset($data['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$data['product_id'];
$price = (float)$data['price'];
$quantity = (int)$data['quantity'];
$image_url = isset($data['image_url']) ? $data['image_url'] : null;

// Detect if 'toys' table exists and set the product table accordingly
$table_check = $conn->query("SHOW TABLES LIKE 'toys'");
$product_table = ($table_check->num_rows > 0) ? 'toys' : 'products';

// Check if product exists using the correct table
$stmt = $conn->prepare("SELECT id FROM {$product_table} WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
    exit();
}

// Check if item already exists in cart
$stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity if item exists
    $cart_item = $result->fetch_assoc();
    $new_quantity = $cart_item['quantity'] + $quantity;
    
    $stmt = $conn->prepare("UPDATE cart SET quantity = ?, price = ?, image_url = ? WHERE id = ?");
    $stmt->bind_param("idsi", $new_quantity, $price, $image_url, $cart_item['id']);
} else {
    // Insert new item if it doesn't exist
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, price, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiids", $user_id, $product_id, $quantity, $price, $image_url);
}

if ($stmt->execute()) {
    // Get updated cart count
    $count_stmt = $conn->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
    $count_stmt->bind_param("i", $user_id);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $cart_count = $count_result->fetch_assoc()['total'] ?? 0;
    
    echo json_encode([
        'success' => true, 
        'message' => 'Item added to cart successfully',
        'cart_count' => $cart_count
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error adding item to cart']);
}

$stmt->close();
$conn->close();
?> 