<?php
# Initialize the session
session_start();

# Redirect to login page if user is not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo "<script>window.location.href='index.html';</script>";
    exit;
}

# Fetch user's name from the session for greeting
$username = isset($_SESSION["name"]) ? htmlspecialchars($_SESSION["name"]) : "User";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - City Cruisers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <style>
        :root {
            --orangish-red: #ff4500; /* Orangish-red color */
            --text-color: #ffffff;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #fff; /* Light grey background for contrast */
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: var(--orangish-red); /* Orangish-red navbar */
            padding: 0.25rem 1rem; /* Reduced padding */
            height:70px;
        }

        .navbar-brand
        {
            font-size:35px;
            color:white;
        }
        .navbar-text{
          font-size:15px;
          color:white;
          margin-left:280px;
        }

        .btn-primary {
            background-color: var(--orangish-red);
            border: none;
            color: var(--text-color);
            padding: 0.5rem 1rem;
            height:30px;
        }

        .btn-primary:hover {
            background-color: #ffffff;
            color: #000;
            opacity: 0.8;
            height:30px;
        }

        .container-fluid {
            margin-top: 20px;
            padding: 1.9rem;
        }
        #log{
          font-size:15px;
        }
    
.form-label {
    color: #333;
    font-size: 30px;
    text-align: right; /* Align text to the right to close gap on left side */
    padding-right: 0.4rem; /* Optional: Reduce padding if needed */
}

.form-control, .form-select {
    margin-left: -1.5rem; /* Shifts dropdown to the left closer to the label */
    border-radius: 5px;
    border: 1px solid #ccc;
}
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - City Cruisers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <style>
        :root {
            --orangish-red: #ff4500; /* Orangish-red color */
            --lighter-orange: #ff7043; /* Lighter shade of orange */
            --text-color: #ffffff;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: var(--orangish-red);
            padding: 0.25rem 1rem;
            height: 70px;
        }

        .navbar-brand {
            font-size: 35px;
            color: white;
        }

        .navbar-text {
            font-size: 15px;
            color: white;
            margin-left: 280px;
        }
        .container-fluid {
            margin-top: 20px;
            padding: 1.9rem;
        }
        .btn-primary, #log {
    background-color: var(--orangish-red);
    border: none;
    color: var(--text-color);
    padding: 0.5rem 1rem;
    height: 30px;
    line-height: 20px; /* Explicit line height for better control */
    display: flex; /* Use flexbox to align text exactly in the center */
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    transition: all 0.2s ease; /* Smooth transition for scaling and background color */
}

.btn-primary:hover {
    background-color: var(--lighter-orange);
    color: #000;
    opacity: 0.9;
    transform: scale(1.05); /* Scale up on hover */
}
#log{
  height:50px;
  align-items:center;
  margin-top:10px;
  padding:10px;
}
 #log:hover{
  color:black;
 } 
        .form-label {
            color: #333;
            font-size: 30px;
            text-align: right;
            padding-right: 0.4rem;
        }

        .form-control, .form-select {
            margin-left: -1.5rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-select {
    width: 100%;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #333;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-select:focus {
    border-color: #ff4500;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(255, 69, 0, 0.25);
}

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.html">City Cruisers</a>
        <div class="navbar-text">
            Cruise the City in Style
        </div>
        
        <div class="ms-auto d-flex">
            <button class="btn btn-primary me-2" onclick="window.location.href='booking.php'">My Bookings</button>
            <button class="btn btn-primary" onclick="window.location.href='./logout.php'">Log Out</button>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <h1 class="mt-5">Reserve Your Seat</h1>
    <h2>Plan Your Journey</h2>
    <form id="searchForm" action="passenger_info.php" method="get">
        <div class="mb-3 row">
            <label for="from" class="col-sm-4 col-form-label">Source:</label>
            <div class="col-sm-8">
                <select name="from" id="from" class="form-select"></select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="to" class="col-sm-4 col-form-label">Destination:</label>
            <div class="col-sm-8">
                <select name="to" id="to" class="form-select"></select>
            </div>
        </div>
        <div class="mb-3 row">
          
        </div>
        <div class="text-center">
            <button type="button" id="log" onclick="searchBuses()">Search Buses</button>
        </div>
    </form>
</div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-zZtmoGmrQqpgp7QjHd2ceDpxjAI63JrS41+jkTvM3eF99oEzbbAC4wA4cY8J+cr" crossorigin="anonymous"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchRoutes();
    });

    function fetchRoutes() {
        fetch('fetch_routes.php')
            .then(response => response.json())
            .then(data => {
                const fromSelect = document.getElementById('from');
                const toSelect = document.getElementById('to');

                fromSelect.innerHTML = '<option>Select</option>';
                toSelect.innerHTML = '<option>Select</option>';

                data.sources.forEach(source => {
                    let option = new Option(source, source);
                    fromSelect.add(option);
                });

                data.destinations.forEach(destination => {
                    let option = new Option(destination, destination);
                    toSelect.add(option);
                });
            })
            .catch(error => {
                console.error('Failed to load route data:', error);
                alert('Failed to load route data.');
            });
    }

    function searchBuses() {
    const from = document.getElementById('from').value;
    const to = document.getElementById('to').value;

    const url = `passenger_info.php?from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}`;
    window.location.href = url;
}

  </script>

</body>
</html>
