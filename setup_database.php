<?php
$conn = new mysqli("localhost", "root", "jay@2003");

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS little_learners";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db("little_learners");

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Users table created successfully or already exists<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Create a test user
$test_email = "test@example.com";
$test_password = password_hash("test123", PASSWORD_DEFAULT);

$sql = "INSERT IGNORE INTO users (email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $test_email, $test_password);

if ($stmt->execute()) {
    echo "Test user created successfully or already exists<br>";
} else {
    echo "Error creating test user: " . $stmt->error . "<br>";
}

$conn->close();
echo "Database setup completed!";
?> 