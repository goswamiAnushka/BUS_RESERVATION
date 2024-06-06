<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "online_bus");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch unique sources and destinations
$sql_sources = "SELECT DISTINCT source FROM bus_details";
$sql_destinations = "SELECT DISTINCT destination FROM bus_details";

$sources = [];
$destinations = [];

// Execute source query
$result_sources = $conn->query($sql_sources);
if ($result_sources) {
    while ($row = $result_sources->fetch_assoc()) {
        $sources[] = $row['source'];
    }
} else {
    error_log("Error fetching sources: " . $conn->error);
}

// Execute destination query
$result_destinations = $conn->query($sql_destinations);
if ($result_destinations) {
    while ($row = $result_destinations->fetch_assoc()) {
        $destinations[] = $row['destination'];
    }
} else {
    error_log("Error fetching destinations: " . $conn->error);
}

// Prepare the data for JSON output
$data = [
    'sources' => $sources,
    'destinations' => $destinations
];

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
$conn->close();
?>
