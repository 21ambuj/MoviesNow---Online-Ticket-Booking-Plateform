<?php
$link = mysqli_connect("localhost", "root", "", "userotb");

if ($link === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

$sql = "CREATE TABLE userr (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    above18 BOOLEAN NOT NULL DEFAULT 0,
    agree BOOLEAN NOT NULL DEFAULT 0,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($link, $sql)) {
    echo "✅ Table created successfully";
} else {
    echo "❌ Error creating table: " . mysqli_error($link);
}
?>
