<?php
session_start();

// Ensuring that only logged-in users can view the cancellations
if (!isset($_SESSION['user_id'])) {
    echo "Please login to access this page.";
    exit();
}

$userId = $_SESSION['user_id'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'online_bus');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching cancelled tickets from the database
$query = "SELECT tc.ticket_id, t.bus_name, t.num_passengers, tc.refund_amount, t.travel_date FROM ticket_cancellations tc JOIN tickets t ON tc.ticket_id = t.ticket_id WHERE t.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$cancelledTickets = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cancelledTickets[] = $row;
    }
} else {
    echo "No cancelled tickets found.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelled Bookings</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #333; /* Dark background for contrast */
        margin: 0;
        padding: 20px;
        color: #fff; /* Light text color */
    }

    h1 {
        color: #ffa500; /* Light orange for headings */
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 80%; /* Reduced width */
        border-collapse: collapse;
        margin: 0 auto 20px; /* Center table */
        background: #444; /* Darker background for table */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Box shadow for depth */
        border-radius: 8px; /* Rounded corners */
        overflow: hidden;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #555; /* Subtle line for separation */
    }

    th {
        background: linear-gradient(145deg, #ff8c00, #ff7f50); /* Gradient background for headers */
        color: #ffffff;
    }

    td {
        color: #ccc; /* Lighter text for content */
    }

    td button {
        background-color: #ff7f50; /* Light orange */
        color: white;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.2s;
    }

    td button:hover {
        background-color: #ff8c00; /* Dark orange */
        transform: scale(1.05); /* Slight increase in size */
    }

    .btn, .btn:hover {
        display: block;
        width: 160px;
        margin: 20px auto;
        background-color: #ff7f50; /* Consistent button styling */
        text-align: center;
        text-decoration: none;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn:hover {
        background-color: #ff8c00;
        transform: scale(1.05);
    }

    a {
        color: black;
    }

    .message {
        text-align: center;
        margin-bottom: 20px;
    }
</style>

</head>
<body>
<h1>Cancelled Tickets</h1>
<?php if (count($cancelledTickets) > 0): ?>
    <table>
        <tr>
            <th>Ticket ID</th>
            <th>Bus Name</th>
            <th>Number of Passengers</th>
            <th>Refund Amount</th>
            <th>Travel Date</th>
        </tr>
        <?php foreach ($cancelledTickets as $ticket): ?>
            <tr>
                <td><?= htmlspecialchars($ticket['ticket_id']) ?></td>
                <td><?= htmlspecialchars($ticket['bus_name']) ?></td>
                <td><?= htmlspecialchars($ticket['num_passengers']) ?></td>
                <td><?= htmlspecialchars($ticket['refund_amount']) ?></td>
                <td><?= htmlspecialchars($ticket['travel_date']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No cancelled bookings found.</p>
<?php endif; ?>
<a href="index2.php" class="btn" >Back to Home</a>
</body>
</html>
