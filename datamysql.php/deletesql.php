<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "userotb";

// Establish MySQL connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}

// Validate and sanitize ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare delete query
    $stmt = $conn->prepare("DELETE FROM userr WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            // Redirect with success message
            header("Location: retrivedata.php?msg=" . urlencode("User deleted successfully ✅"));
            exit();
        } else {
            $error = "❌ Failed to delete user. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "❌ Failed to prepare delete query.";
    }
} else {
    $error = "❌ Invalid user ID.";
}

// Close connection and show error if redirection failed
$conn->close();
echo "<p style='color: red; font-family: sans-serif; text-align: center;'>{$error}</p>";
echo "<p style='text-align: center;'><a href='user_admin.php'>⬅ Back to User Panel</a></p>";
?>
