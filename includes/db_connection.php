<?php
// Database connection settings for XAMPP
$host = 'localhost';      // XAMPP MySQL host
$username = 'root';       // XAMPP default username
$password = 'jay@2003';   // Your MySQL root password
$database = 'little_learners';

// Create connection - with error handling
try {
    // First try to connect to MySQL without selecting a database
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    if ($conn->query($sql) === FALSE) {
        throw new Exception("Error creating database: " . $conn->error);
    }
    
    // Select the database
    if (!$conn->select_db($database)) {
        throw new Exception("Error selecting database: " . $conn->error);
    }
    
    // Set charset to utf8mb4
    if (!$conn->set_charset("utf8mb4")) {
        throw new Exception("Error setting charset: " . $conn->error);
    }
    
    // Create users table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        first_name VARCHAR(50),
        last_name VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($sql) === FALSE) {
        throw new Exception("Error creating users table: " . $conn->error);
    }
    
    // Create products table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        image_url VARCHAR(255),
        category VARCHAR(50),
        age_range VARCHAR(20),
        stock INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($sql) === FALSE) {
        throw new Exception("Error creating products table: " . $conn->error);
    }
    
    // Create likes table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS likes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        item_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        UNIQUE KEY unique_like (user_id, item_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($sql) === FALSE) {
        throw new Exception("Error creating likes table: " . $conn->error);
    }
    
    // Create cart table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($sql) === FALSE) {
        throw new Exception("Error creating cart table: " . $conn->error);
    }
    
    // Create orders table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        total_amount DECIMAL(10,2) NOT NULL,
        status VARCHAR(50) DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($sql) === FALSE) {
        throw new Exception("Error creating orders table: " . $conn->error);
    }
    
    // Create order_items table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($sql) === FALSE) {
        throw new Exception("Error creating order_items table: " . $conn->error);
    }
    
    // Create game_scores table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS game_scores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        game_name VARCHAR(50) NOT NULL,
        score INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($sql) === FALSE) {
        throw new Exception("Error creating game_scores table: " . $conn->error);
    }
    
    // Insert sample products if the table is empty
    $result = $conn->query("SELECT COUNT(*) as count FROM products");
    $row = $result->fetch_assoc();
    if ($row['count'] == 0) {
        $sample_products = [
            [
                "name" => "Color Blocks",
                "description" => "Soft, colorful blocks perfect for toddlers to stack and sort. Boosts motor skills and early learning through fun play.",
                "price" => 24.99,
                "image_url" => "images/images/toys/color-blocks.jpg",
                "category" => "Building",
                "age_range" => "0-2"
            ],
            [
                "name" => "Alphabet Puzzle",
                "description" => "Fun way to learn ABCs with durable wooden pieces. Helps build early literacy and fine motor skills.",
                "price" => 19.99,
                "image_url" => "images/images/toys/alphabet-puzzle.jpg",
                "category" => "Puzzles",
                "age_range" => "3-5"
            ],
            [
                "name" => "Number Match",
                "description" => "Interactive number learning game. Perfect for counting practice and early math skills.",
                "price" => 29.99,
                "image_url" => "images/images/toys/number-match.jpg",
                "category" => "Math",
                "age_range" => "6-8"
            ]
        ];
        
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url, category, age_range) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($sample_products as $product) {
            $stmt->bind_param("ssdsss", 
                $product['name'],
                $product['description'],
                $product['price'],
                $product['image_url'],
                $product['category'],
                $product['age_range']
            );
            $stmt->execute();
        }
    }
    
} catch (Exception $e) {
    // Log the error and show a user-friendly message
    error_log($e->getMessage());
    die("Sorry, there was a problem connecting to the database. Please try again later.");
}
?> 