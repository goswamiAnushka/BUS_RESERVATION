<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

// Database connection
$servername = "sql304.infinityfree.com";
$username = "if0_36951682";
$password = "aCztWA2z1Ygd";
$dbname = "if0_36951682_cistycruisers";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            color: #ff2500;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        a {
            color: #ff2500;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .container {
            width: 90%;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></h1>

        <h2>Bus Details</h2>
        <table>
            <tr>
                <th>Bus ID</th>
                <th>Bus Name</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Fare</th>
                <th>Seats Available</th>
                <th>Bus Type</th>
            </tr>
            <?php
            $sql = "SELECT * FROM bus_details";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['bus_id']}</td>
                        <td>{$row['bus_name']}</td>
                        <td>{$row['source']}</td>
                        <td>{$row['destination']}</td>
                        <td>{$row['fare']}</td>
                        <td>{$row['seats_available']}</td>
                        <td>{$row['bus_type']}</td>
                    </tr>";
                }
            }
            ?>
        </table>

        <h2>Booking Details</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Ticket ID</th>
                <th>Bus Name</th>
                <th>Num Passengers</th>
                <th>Total Fare</th>
                <th>Travel Date</th>
                <th>Cancellation ID</th>
                <th>Refund Amount</th>
                <th>Cancellation Time</th>
            </tr>
            <?php
            // Assuming GetAllBookingDetails is a valid stored procedure
            $sql = "CALL GetAllBookingDetails()";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['user_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['contact_number']}</td>
                        <td>{$row['ticket_id']}</td>
                        <td>{$row['bus_name']}</td>
                        <td>{$row['num_passengers']}</td>
                        <td>{$row['total_fare']}</td>
                        <td>{$row['travel_date']}</td>
                        <td>{$row['cancellation_id']}</td>
                        <td>{$row['refund_amount']}</td>
                        <td>{$row['cancellation_time']}</td>
                    </tr>";
                }
            }
            ?>
        </table>

        <a href="logout.php">Logout</a>
    </div>

    <?php
    $conn->close();
    ?>
</body>
</html>
