<?php
header('Content-Type: application/json');

// Connect to the database
$conn = new mysqli("localhost", "root", "", "online_bus");

// Check for connection error
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Collect and sanitize input data
$from = isset($_GET['from']) ? $conn->real_escape_string($_GET['from']) : null;
$to = isset($_GET['to']) ? $conn->real_escape_string($_GET['to']) : null;

// Validate input
if (!$from || !$to) {
    echo json_encode(['error' => 'Required parameters are missing.']);
    exit;
}

// Query to fetch available buses based on the source and destination
$sql = "SELECT bus_name, details, fare, seats_available FROM bus_details WHERE source = ? AND destination = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'MySQL prepare error: ' . $conn->error]);
    exit;
}

// Bind parameters and execute the query
$stmt->bind_param('ss', $from, $to);
$stmt->execute();
$result = $stmt->get_result();
$buses = [];

while ($row = $result->fetch_assoc()) {
    $buses[] = [
        'bus_name' => $row['bus_name'],
        'details' => $row['fare'] . ' USD, ' . $row['seats_available'] . ' seats available'
    ];
}

// Return the bus information as JSON
echo json_encode($buses);

// Clean up
$stmt->close();
$conn->close();
?>
