<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;

$name = $_GET['name'] ?? 'Unknown';
$seats = $_GET['seats'] ?? 'N/A';
$amount = $_GET['total_amount'] ?? 0;
$payment_id = $_GET['payment_id'] ?? 'Not Available';


$amountFormatted = number_format($amount / 100, 2);

// ✅ Use SVG writer (no GD needed)
$qrCode = new QrCode("Name: $name\nSeats: $seats\nPayment ID: $payment_id\nAmount: ₹$amountFormatted");
$writer = new SvgWriter();
$qrCodeImage = $writer->write($qrCode);

// Convert QR SVG to base64
$qrCodeData = base64_encode($qrCodeImage->getString());

$html = "
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; }
        h1 { text-align: center; font-size: 24px; color: #333; }
        .ticket-info { font-size: 16px; line-height: 1.5; margin-bottom: 20px; }
        .ticket-info p { margin: 8px 0; }
        .footer { text-align: center; font-size: 14px; color: #777; }
        .qr-code { text-align: center; margin-top: 20px; }
    </style>
    <div class='container'>
        <h1>MoviesNow</h1>
        <p>Movie and Events Ticket Details:-</p>
        <div class='ticket-info'>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Seats:</strong> $seats</p>
           
            <p><strong>Payment ID:</strong> $payment_id</p>
            <p><strong>Total Paid:</strong> Rs.$amountFormatted</p>
        </div>
        <div class='qr-code'>
            <img src='data:image/svg+xml;base64," . $qrCodeData . "' width='150' height='150' />
        </div>
        <hr>
        <div class='footer'>
            <p>Thank you! Enjoy the Movies And Events! 🍿</p>
        </div>
    </div>
";

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A5', 'portrait');
$dompdf->render();

header("Content-Type: application/pdf");
$dompdf->stream("Movie_Ticket_$payment_id.pdf", array("Attachment" => false));
exit;
