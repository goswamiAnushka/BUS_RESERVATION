<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Booking Details</title>
    <style>
        body {
            background-color: #2B2B2B;
            color: #ff2500;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        h2 {
            margin: 20px 0;
            font-size: 32px;
            color: #FF5722;
        }
        table-container {
            overflow-x: auto;
            width: 100%;
            margin-top: 20px;
        }
        table {
            width: 100%;
            background-color: #111;
            color: #ccc;
            border-collapse: collapse;
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
            border: 1px solid #333;
            font-size: 14px;
        }
        th {
            background-color: #333;
            color: #FF5722;
        }
        input[type="submit"] {
            background-color: #ff2500;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #FF5722;
        }
    </style>
</head>
<body>
<?php
// Establish database connection
$servername = "sql304.infinityfree.com";
$username = "if0_36951682";
$password = "aCztWA2z1Ygd";
$dbname = "if0_36951682_cistycruisers";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Call the procedure to get all booking details
$sql = "CALL GetAllBookingDetails()";
$result = $conn->query($sql);
?>
<?php if ($result->num_rows > 0): ?>
    <h2>All Booking Details</h2>
    <table-container>
        <table>
            <tr><th>User ID</th><th>Name</th><th>Email</th><th>Ticket ID</th><th>Bus Name</th><th>Num Passengers</th><th>Total Fare</th><th>Travel Date</th><th>Cancellation ID</th><th>Refund Amount</th><th>Cancellation Time</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["user_id"]) ?></td>
                    <td><?= htmlspecialchars($row["name"]) ?></td>
                    <td><?= htmlspecialchars($row["email"]) ?></td>
                    <td><?= htmlspecialchars($row["ticket_id"]) ?></td>
                    <td><?= htmlspecialchars($row["bus_name"]) ?></td>
                    <td><?= htmlspecialchars($row["num_passengers"]) ?></td>
                    <td><?= htmlspecialchars($row["total_fare"]) ?></td>
                    <td><?= htmlspecialchars($row["travel_date"]) ?></td>
                    <td><?= htmlspecialchars($row["cancellation_id"]) ?></td>
                    <td><?= htmlspecialchars($row["refund_amount"]) ?></td>
                    <td><?= htmlspecialchars($row["cancellation_time"]) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </table-container>
<?php else: ?>
    <h2>No booking details found.</h2>
<?php endif; ?>

<!-- Logout Button -->
<form action="index.html" method="GET">
    <input type="submit" value="Logout" />
</form>

<?php $conn->close(); ?>
</body>
</html>
