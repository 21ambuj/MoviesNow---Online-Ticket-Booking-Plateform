<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "userotb";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, email, age, gender, above18, agree, created_at FROM userr ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management Panel</title>
    <style>
        body {
            background: linear-gradient(to right, #43cea2, #185a9d);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #185a9d;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #185a9d;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f5faff;
        }
        tr:hover {
            background-color: #ebf5fc;
        }
        a.delete-link {
            color: crimson;
            text-decoration: none;
            font-weight: bold;
        }
        a.delete-link:hover {
            text-decoration: underline;
        }
        .success {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th {
                display: none;
            }
            td {
                position: relative;
                padding-left: 50%;
            }
            td::before {
                position: absolute;
                top: 10px;
                left: 10px;
                font-weight: bold;
                content: attr(data-label);
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>👥 Registered Users</h2>
    <?php
    if (isset($_GET['msg'])) {
        echo "<p class='success'>" . htmlspecialchars($_GET['msg']) . "</p>";
    }

    if ($result && $result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Above 18</th>
                        <th>Agreed</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td data-label='ID'>{$row['id']}</td>
                    <td data-label='Username'>" . htmlspecialchars($row['username']) . "</td>
                    <td data-label='Email'>" . htmlspecialchars($row['email']) . "</td>
                    <td data-label='Age'>{$row['age']}</td>
                    <td data-label='Gender'>{$row['gender']}</td>
                    <td data-label='Above 18'>" . ($row['above18'] ? 'Yes' : 'No') . "</td>
                    <td data-label='Agreed'>" . ($row['agree'] ? 'Yes' : 'No') . "</td>
                    <td data-label='Created At'>{$row['created_at']}</td>
                    <td data-label='Action'>
                        <a href='deletesql.php?id={$row['id']}' 
                           class='delete-link' 
                           onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete ❌</a>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No users found.</p>";
    }
    $conn->close();
    ?>
</div>
</body>
</html>
