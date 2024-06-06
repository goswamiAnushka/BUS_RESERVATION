<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Please login to view your bookings.";
    exit();
}

$userId = $_SESSION['user_id'];

$conn = new mysqli('localhost', 'root', '', 'online_bus');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_ticket'])) {
    $ticketId = $_POST['ticket_id'];
    $fareQuery = "SELECT total_fare FROM tickets WHERE ticket_id = ? AND user_id = ?";
    $fareStmt = $conn->prepare($fareQuery);
    $fareStmt->bind_param("ii", $ticketId, $userId);
    $fareStmt->execute();
    $fareResult = $fareStmt->get_result();
    if ($fareRow = $fareResult->fetch_assoc()) {
        $totalFare = $fareRow['total_fare'];
        $refundAmount = $totalFare - ($totalFare * 0.30); // Calculate refund as 70% of total fare
    
        // Check if the ticket belongs to the logged-in user
        $checkQuery = "SELECT * FROM tickets WHERE ticket_id = ? AND user_id = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("ii", $ticketId, $userId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows === 0) {
            echo "You are not authorized to cancel this ticket.";
        } else {
            // Insert the cancelled ticket into the ticket_cancellations table
            $cancelQuery = "INSERT INTO ticket_cancellations (ticket_id, refund_amount) VALUES (?, ?)";
            $cancelStmt = $conn->prepare($cancelQuery);
            $cancelStmt->bind_param("id", $ticketId, $refundAmount);
            if ($cancelStmt->execute()) {
                // Update ticket status to 'cancelled'
                $updateStatusQuery = "UPDATE tickets SET status = 'cancelled' WHERE ticket_id = ?";
                $updateStatusStmt = $conn->prepare($updateStatusQuery);
                $updateStatusStmt->bind_param("i", $ticketId);
                $updateStatusStmt->execute();
                
                echo "Ticket cancelled successfully.";
            } else {
                echo "Error cancelling ticket: " . $conn->error;
            }
        }
    }
}

$query = "SELECT ticket_id, bus_name, num_passengers, total_fare, travel_date, booking_time FROM tickets WHERE user_id = ? AND status <> 'cancelled'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$tickets = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
} else {
    echo "No active tickets found.";
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
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
        a{
            color:black;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>

</head>
<body>
    <h1>Your Bookings</h1>
    <?php if (count($tickets) > 0): ?>
        <table>
            <tr>
                <th>Ticket ID</th>
                <th>Bus Name</th>
                <th>Number of Passengers</th>
                <th>Total Fare</th>
                <th>Travel Date</th>
                <th>Booking Time</th>
                <th>Action</th>
            </tr>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= htmlspecialchars($ticket['ticket_id']) ?></td>
                    <td><?= htmlspecialchars($ticket['bus_name']) ?></td>
                    <td><?= htmlspecialchars($ticket['num_passengers']) ?></td>
                    <td><?= htmlspecialchars($ticket['total_fare']) ?></td>
                    <td><?= htmlspecialchars($ticket['travel_date']) ?></td>
                    <td><?= htmlspecialchars($ticket['booking_time']) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="ticket_id" value="<?= $ticket['ticket_id'] ?>">
                            <button type="submit" name="cancel_ticket" onclick="return confirmCancellation();">Cancel</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>

    <form action="view_cancelled_tickets.php" method="get">
        <button type="submit" class="btn">View Cancelled Tickets</button>
    </form>

    <a href="index2.php" class="btn" >Back to Home</a>

    <script>
        function confirmCancellation() {
            return confirm('30% of the amount will be deducted according to our terms and conditions. Do you want to continue?');
        }
    </script>
</body>
</html>
