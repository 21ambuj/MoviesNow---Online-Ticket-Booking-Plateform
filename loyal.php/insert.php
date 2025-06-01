<?php
include 'loyality.php';

$conn->select_db("showai");

// Sample user
$conn->query("INSERT INTO users (username, password, email) VALUES 
('john_doe', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'john@example.com')");

// Sample offers
$offers = [
    ["Flat 15% Cashback", "On all movie tickets", 500, "2025-06-30", "BANK OFFER", "Use code HDFC15 and get 15% cashback up to ₹150"],
    ["Buy 1 Get 1 Free", "On weekend shows", 750, "2025-07-15", "WALLET OFFER", "Book tickets using Paytm wallet"],
    ["Flat ₹100 Off", "On min booking of ₹500", 300, "2025-08-31", "BANK OFFER", "When you book using ICICI Bank credit cards"],
    ["Free Popcorn Combo", "With every ticket purchase", 200, "2025-09-30", "REWARD OFFER", "Get a free medium popcorn and drink with any ticket purchase"],
    ["Weekday Special", "20% off on weekday shows", 350, "2025-10-15", "DISCOUNT OFFER", "Get 20% off on all weekday movie shows"],
    ["Family Package", "Discount for family of 4", 600, "2025-09-15", "PACKAGE OFFER", "Special discount when purchasing 4 tickets together"],
    ["Student Discount", "25% off for students", 250, "2025-12-31", "STUDENT OFFER", "Valid student ID required at box office"],
    ["Early Bird Special", "25% off for early bookings", 150, "2025-10-31", "EARLY BIRD OFFER", "Book tickets 2 weeks in advance to avail this offer"],
    ["3D Movie Discount", "Flat 20% off on 3D movies", 400, "2025-11-30", "3D MOVIE OFFER", "Applicable on all 3D movie tickets"]
];

foreach ($offers as $offer) {
    $stmt = $conn->prepare("INSERT INTO offers (title, description, points_required, valid_until, offer_type, discount_details) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $offer[0], $offer[1], $offer[2], $offer[3], $offer[4], $offer[5]);
    $stmt->execute();
}
echo "Sample data inserted";
$conn->close();
?>
