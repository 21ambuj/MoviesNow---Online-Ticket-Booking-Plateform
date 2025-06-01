<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection (without selecting DB first)
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS showai";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the newly created database
$conn->select_db("showai");

// Create 'users' table
// Create 'offers' table
$offers = "CREATE TABLE IF NOT EXISTS offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    points_required INT NOT NULL,
    valid_until DATE NOT NULL,
    offer_type VARCHAR(20) NOT NULL,
    discount_details TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($offers);

// Create 'redemptions' table
$redemptions = "CREATE TABLE IF NOT EXISTS redemptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    offer_id INT NOT NULL,
    redeemed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (offer_id) REFERENCES offers(id)
)";
$conn->query($redemptions);

echo "Tables created successfully";

$conn->close();
?>
