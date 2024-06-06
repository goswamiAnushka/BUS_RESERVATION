<?php
session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'online_bus';
$username = 'root';
$password = '';

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the source and destination are set
if (!isset($_GET['from']) || !isset($_GET['to'])) {
    echo "<script> alert('Required parameters for source and destination are missing.'); </script>";
    exit();
}

$source = $_GET['from'];
$destination = $_GET['to'];

// Prepare SQL query to fetch available buses based on source and destination
$query = "SELECT bus_id, bus_name, source, destination, fare, seats_available, bus_type 
          FROM bus_details 
          WHERE source = ? AND destination = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $source, $destination);
$stmt->execute();
$result = $stmt->get_result();

$buses = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $buses[] = $row;
    }
} else {
    // Handle the case when no buses are available
    echo "No buses available for the selected route.";
    $stmt->close();
    $conn->close();
    exit(); // Exit the script since there are no buses to display
}

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedBus'], $_POST['numPassengers'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('User ID missing. Please log in again.');</script>";
        exit();
    }

    // Save bus and passenger details to session
    $selectedBus = json_decode($_POST['selectedBus'], true);
    $_SESSION['selected_bus'] = $selectedBus;
    $_SESSION['bus_id'] = $selectedBus['bus_id']; // Storing bus ID in session
    $_SESSION['num_passengers'] = $_POST['numPassengers'];
    $_SESSION['travel_date'] = $_POST['travelDate'];

    // Initialize or clear the session array for passengers
    $_SESSION['passengers'] = [];

    // Gather passenger data
    for ($i = 1; $i <= $_SESSION['num_passengers']; $i++) {
        if (isset($_POST["passenger_name_$i"], $_POST["contact_number_$i"], $_POST["age_$i"])) {
            $_SESSION['passengers'][] = [
                'name' => $_POST["passenger_name_$i"],
                'contact' => $_POST["contact_number_$i"],
                'age' => $_POST["age_$i"]
            ];
        }
    }

    // Calculate total fare
    $totalFare = $_SESSION['selected_bus']['fare'] * $_SESSION['num_passengers'];
    $travelDate = $_SESSION['travel_date'];
    $userId = $_SESSION['user_id'];
    $busName = $_SESSION['selected_bus']['bus_name'];

    // Prepare SQL to insert ticket details
    $stmt = $conn->prepare("INSERT INTO tickets (bus_name, num_passengers, total_fare, travel_date, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sidsi", $busName, $_SESSION['num_passengers'], $totalFare, $travelDate, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirect to payment page after successful insert
        header('Location: payment_page.php');
        exit();
    } else {
        echo "Error saving ticket: " . $stmt->error;
    }

    $stmt->close();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Selection and Passenger Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#ff9f00 ;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 600px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            background-color: #fff;
            border-radius: 8px;
            margin: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #FF4500; /* Darker orange */
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #FF4500; /* Border color */
        }
        button {
            background-color: #FF4500; /* Dark orange button color */
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #FF6347; /* Lighter orange on hover */
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd; /* Light gray border between rows */
        }
        th {
         background-color: #FF4500; /* Darker orange table header */
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Select Your Bus and Enter Passenger Details</h2>
    <form id="busSelectionForm" method="post" action="">


        <!-- Bus selection table -->
        <table>
            <tr>
                <th>Select</th>
                <th>Bus Name</th>
                <th>Fare</th>
                <th>Seats Available</th>
                <th>Type</th>
            </tr>
            <?php foreach ($buses as $bus): ?>
                <tr>
                    <td><input type="radio" name="selectedBus" value="<?= htmlspecialchars(json_encode($bus)); ?>" required></td>
                    <td><?= htmlspecialchars($bus['bus_name']); ?></td>
                    <td><?= htmlspecialchars($bus['fare']); ?></td>
                    <td><?= htmlspecialchars($bus['seats_available']); ?></td>
                    <td><?= htmlspecialchars($bus['bus_type']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
         <!-- Date of Travel -->
        <label for="travelDate">Date of Travel:</label>
        <input type="date" id="travelDate" name="travelDate" required>
        <!-- Number of Passengers input field -->
        <label for="numPassengers">Number of Passengers:</label>
        <input type="number" id="numPassengers" name="numPassengers" min="1" placeholder="Enter number of passengers" onchange="addPassengerFields()" required>

<!-- Dynamic Passenger Fields Container -->
          <div id="passengerFields"></div>

        <!-- Submit Button -->
        <button type="submit">Proceed with Selected Bus</button>
    </form>
</div>
<!-- Add this script in the <head> section -->
<script>
    function addPassengerFields() {
        var numPassengers = document.getElementById("numPassengers").value;
        var passengerFieldsContainer = document.getElementById("passengerFields");
        passengerFieldsContainer.innerHTML = ""; // Clear previous fields

        for (var i = 1; i <= numPassengers; i++) {
            var passengerFieldset = document.createElement("fieldset");
            passengerFieldset.innerHTML = "<legend>Passenger " + i + "</legend>" +
                "<label for='passenger_name_" + i + "'>Name:</label>" +
                "<input type='text' id='passenger_name_" + i + "' name='passenger_name_" + i + "' required>" +
                "<label for='contact_number_" + i + "'>Contact Number:</label>" +
                "<input type='text' id='contact_number_" + i + "' name='contact_number_" + i + "' required>" +
                "<label for='age_" + i + "'>Age:</label>" +
                "<input type='number' id='age_" + i + "' name='age_" + i + "' required>";
            passengerFieldsContainer.appendChild(passengerFieldset);
        }
    }
</script>

</body>
</html>