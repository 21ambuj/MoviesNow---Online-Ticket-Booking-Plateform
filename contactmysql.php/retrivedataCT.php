<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "contactform";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, email, message, submitted_at FROM messagess ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Messages</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #2575fc;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #2575fc;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f4f7ff;
        }
        tr:hover {
            background-color: #eef2ff;
        }
        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            td {
                padding: 10px;
                border-bottom: 1px solid #ddd;
                position: relative;
            }
            td::before {
                content: attr(data-label);
                font-weight: bold;
                position: absolute;
                left: 10px;
                top: 10px;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📩 Contact Messages</h2>
        <?php
        if ($result && $result->num_rows > 0) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td data-label='ID'>{$row['id']}</td>
                        <td data-label='Name'>" . htmlspecialchars($row['name']) . "</td>
                        <td data-label='Email'>" . htmlspecialchars($row['email']) . "</td>
                        <td data-label='Message'>" . nl2br(htmlspecialchars($row['message'])) . "</td>
                        <td data-label='Submitted At'>{$row['submitted_at']}</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No messages found.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
