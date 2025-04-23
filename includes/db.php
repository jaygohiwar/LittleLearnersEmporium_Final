<?php
$conn = new mysqli("localhost", "root", "jay@2003", "little_learners");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
