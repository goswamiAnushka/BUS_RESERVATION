<?php
session_start();
require 'db.php'; // Include your database connection

// Ensure required session variables are set
if (!isset($_SESSION['selected_bus'], $_SESSION['num_passengers'], $_SESSION['travel_date'])) {
    header('Location: index2.php'); // Redirect if necessary
    exit();
}

// Extracting session variables
$busId = $_SESSION['selected_bus']['bus_id'];
$totalFare = $_SESSION['selected_bus']['fare'] * $_SESSION['num_passengers'];
$numPassengers = $_SESSION['num_passengers'];
$busName = $_SESSION['selected_bus']['bus_name'];

// Retrieve user input from POST
$ticketName = isset($_POST['myName']) ? $_POST['myName'] : 'Unknown';

// Fetching driver details from the database
$sql = "SELECT dd.driver_name, dd.license_number, dd.contact_number FROM driver_details AS dd
        JOIN driver_bus_assignment AS dba ON dd.driver_id = dba.driver_id
        WHERE dba.bus_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$busId]);
$driverDetails = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$driverDetails) {
    $driverDetails = ['driver_name' => 'Not Assigned', 'license_number' => 'N/A', 'contact_number' => 'N/A'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eceff1;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            max-width: 650px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            border-left: 5px solid #FF5722;
        }

        h1 {
            border-bottom: 2px solid #FF5722;
            padding-bottom: 10px;
            color: #FF5722;
            text-align: center;
        }

        .ticket-details {
            background-color: #fafafa;
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
        }

        .ticket-details p {
            font-size: 16px;
            color: #555;
        }

        button, a {
            background-color: #FF5722;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
            font-weight: bold;
            text-align: center;
            width: 150px; /* Uniform button and link size */
        }

        button:hover, a:hover {
            background-color: #FF7043;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bus Ticket</h1>
        <div class="ticket-details">
            <p><strong>Bus Route:</strong> <?php echo htmlspecialchars($busName); ?></p>
            <p><strong>Number of Passengers:</strong> <?php echo $numPassengers; ?></p>
            <p><strong>Total Fare:</strong> ₹<?php echo number_format($totalFare, 2); ?></p>
            <p><strong>Booking Name:</strong> <?php echo htmlspecialchars($ticketName); ?></p>
            <p><strong>Driver Name:</strong> <?php echo htmlspecialchars($driverDetails['driver_name']); ?></p>
            <p><strong>License Number:</strong> <?php echo htmlspecialchars($driverDetails['license_number']); ?></p>
            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($driverDetails['contact_number']); ?></p>
        </div>
        <div class="footer">
            <button onclick="window.print()">Print Ticket</button>
            <a href="index2.php">Back to Home</a>
        </div>
    </div>
</body>
</html>