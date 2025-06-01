<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "userotb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Sample data (replace with $_POST[] values in real form)
$username = "check";
$email = "check@example.com";
$password = password_hash("check21", PASSWORD_BCRYPT); // hashed password
$age = 21;
$gender = "Male";
$above18 = true;
$agree = true;

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO userr (username, email, password, age, gender, above18, agree) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssissi", $username, $email, $password, $age, $gender, $above18, $agree);

// Execute
if ($stmt->execute()) {
    echo "✅ Data inserted successfully.";
} else {
    echo "❌ Error inserting data: " . $stmt->error;
}

// Close
$stmt->close();
$conn->close();
?>
