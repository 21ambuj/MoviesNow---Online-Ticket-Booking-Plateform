<?php
require('vendor/autoload.php'); // Composer autoloader

use Razorpay\Api\Api;

// Razorpay API credentials
$api_key = 'rzp_test_Oo31Muy4R7xzyI';
$api_secret = 'Gu7lz8SB25XQXlofAkrzKtVs';

$api = new Api($api_key, $api_secret);

// Get seats and total amount from URL query parameters
$seats = isset($_GET['seats']) ? $_GET['seats'] : 'Not specified';
$totalAmount = isset($_GET['total']) ? (int) $_GET['total'] : 100; 

// Create Razorpay Order
$orderData = [
    'receipt' => 'receipt_' . uniqid(),
    'amount' => $totalAmount, 
    'currency' => 'INR',
    'payment_capture' => 1
];

$order = $api->order->create($orderData);
$order_id = $order['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pay with UPI - Razorpay</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<div class="max-w-md mx-auto bg-white p-6 rounded-2xl shadow-xl border border-gray-200 mt-10">
  <h2 class="text-2xl font-semibold text-green-600 text-center mb-4">
    Pay ₹<?php echo $totalAmount / 100; ?> using UPI
  </h2>

  <p class="text-gray-700 text-center mb-6">
    <strong>Booked Seats:</strong> <?php echo htmlspecialchars($seats); ?>
  </p>
  <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 ">Your Name</label>
    <input type="text" id="username" class="mt-2 block w-full border-gray-300  shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder=" Enter your name" required>
  </div>

  <div class="flex justify-center">
    <button id="rzp-button" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">
      Pay Now
    </button>
  </div>
</div>

 


    <script>
    var options = {
    "key": "<?php echo $api_key; ?>",
    "amount": "<?php echo $totalAmount; ?>", 
    "currency": "INR",
    "name": "MoviesNow",
    "description": "Seat Booking Payment for seats: <?php echo $seats; ?>",
    "order_id": "<?php echo $order_id; ?>",
    "handler": function (response) {
    const paymentId = response.razorpay_payment_id;
    const seats = "<?php echo $seats; ?>";
    const totalAmount = "<?php echo $totalAmount; ?>";
    const name = document.getElementById("username").value || 'Anonymous';

    
    alert("✅ Payment Successful!\nName: " + name + "\nPayment ID: " + paymentId + "\nSeats: " + seats + "\nAmount: ₹" + (totalAmount / 100));

    // Redirect to dashboard.php with payment details
    window.location.href = 'dashboard.php?payment_id=' + encodeURIComponent(paymentId) +
        '&seats=' + encodeURIComponent(seats) +
        '&total_amount=' + totalAmount +
        '&name=' + encodeURIComponent(name);
}
,
    "prefill": {
        "name": "Ambuj Kumar",
        "email": "ambuj@example.com",
        "contact": "9999999999"
    },
    "theme": {
        "color": "#3399cc"
    },
    "method": {
        "upi": true,
        "card": false,
        "netbanking": false,
        "wallet": false
    }
};


var rzp = new Razorpay(options);
document.getElementById('rzp-button').onclick = function(e){
    const name = document.getElementById("username").value;
    if (!name) {
        alert("Please enter your name before proceeding.");
        return;
    }
    rzp.open();
    e.preventDefault();
}



    </script>
</body>
</html>
