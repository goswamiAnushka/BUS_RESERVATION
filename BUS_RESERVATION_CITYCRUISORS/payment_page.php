
<?php
session_start();

// Database connection
require_once 'config.php'; // Assume all database connection settings are in this file

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure essential session variables are set
if (!isset($_SESSION['selected_bus'], $_SESSION['num_passengers'], $_SESSION['travel_date'], $_SESSION['bus_id'])) {
    header('Location: index2.php'); // Redirect to homepage if necessary session variables are missing
    exit();
}

// Fetch fare details from session
$totalFare = $_SESSION['selected_bus']['fare'] * $_SESSION['num_passengers'];
$taxAmount = $totalFare * 0.15;
$totalFareWithTax = $totalFare + $taxAmount;
$discountAmount = 0; // Initialize discount amount

// Fetch discount codes from the database
$discountQuery = "SELECT * FROM discounts WHERE active = 1 AND valid_from <= CURDATE() AND valid_until >= CURDATE()";
$discountsResult = $conn->query($discountQuery);
$discountOptions = [];

while ($row = $discountsResult->fetch_assoc()) {
    $discountOptions[] = $row;
}

// Process discount application
if (isset($_POST['discount_code'])) {
    $selectedDiscount = $_POST['discount_code'];
    foreach ($discountOptions as $option) {
        if ($option['code'] == $selectedDiscount && $totalFare >= $option['min_fare']) {
            $calculatedDiscount = ($totalFare * $option['percentage_off']) / 100;
            $discountAmount = $option['max_discount_amount'] !== NULL ? min($calculatedDiscount, $option['max_discount_amount']) : $calculatedDiscount;
            $totalFareWithTax -= $discountAmount;
            break;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #FFA726;
    color: #333;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}

h1 {
    color: #FF5722;
}

.fare-details p {
    font-size: 16px;
    color: #555;
}

label {
    display: block;
    margin: 12px 0 6px;
}

input[type="text"],
input[type="email"],
input[type="number"],
input[type="password"],
input[type="date"],
textarea,
select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #FF5722;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #FF5722;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 20px;
}

input[type="submit"]:hover {
    background-color: #FF7043;
}

/* Gender specific styles */
.gender-field {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-left: 0;
}

.gender-label {
    margin-right: 20px;
}

    </style>
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <label for="discount_code">Discount Code:</label>
            <select name="discount_code" id="discount_code" onchange="this.form.submit()">
                <option value="">Select Discount</option>
                <?php foreach ($discountOptions as $option): ?>
                    <option value="<?php echo htmlspecialchars($option['code']); ?>" <?php echo (isset($selectedDiscount) && $selectedDiscount == $option['code']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($option['description']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <div class="fare-details">
        <!-- Display bus details including bus ID -->
        <p>Bus ID: <?php echo htmlspecialchars($_SESSION['bus_id']); ?></p>
        <p>Bus Name: <?php echo htmlspecialchars($_SESSION['selected_bus']['bus_name']); ?></p>
        <p>Number of Passengers: <?php echo $_SESSION['num_passengers']; ?></p>
        <p>Total Base Fare: ₹<?php echo number_format($totalFare, 2); ?></p>
        <p>Tax (15%): ₹<?php echo number_format($taxAmount, 2); ?></p>
        <p>Discount: ₹<?php echo number_format($discountAmount, 2); ?></p>
        <p>Total Fare: ₹<?php echo number_format($totalFareWithTax, 2); ?></p>
    </div>

        <form action="ticket_page.php" autocomplete="off" method="post" onsubmit="return validate()">
        <div>
    <label for="myName">Name:</label>
    <input type="text" name="myName" id="myName" required placeholder="Type your name">
</div>
<div class="gender-field">
    <label class="gender-label">Gender:</label>
    <input type="radio" name="myGndr" id="myGndrMale" value="male" required>
    <label for="myGndrMale" class="radio-label">Male</label>
    <input type="radio" name="myGndr" id="myGndrFemale" value="female" required>
    <label for="myGndrFemale" class="radio-label">Female</label>
</div>
<div>
    <label for="myText">Address:</label>
    <textarea name="myText" id="myText" cols="30" rows="3" required></textarea>
</div>

            <div>
                <label for="email_name">Email:</label>
                <input type="email" name="email_name" id="email_name" required placeholder="example@example.com">
            </div>
            <div>
                <label for="pin_name">Pincode:</label>
                <input type="number" name="pin_name" id="pin_name" required placeholder="111111" minlength="6" maxlength="6">
            </div>
            <hr>
            <h3>Payment Info</h3>
            <div>
                <label for="myCard">Card Type:</label>
                <select name="myCard" id="myCard" required>
                    <option value="">--Select card type--</option>
                    <option value="masterCard">Master Card</option>
                    <option value="debitCard">Debit Card</option>
                </select>
            </div>
            <div>
                <label for="cardNumber_name">Card Number:</label>
                <input type="text" name="cardNumber_name" id="cardNumber_name" required placeholder="1111-2222-3333-4444" minlength="16" maxlength="16">
            </div>
            <div>
                <label for="exDate_name">Expiry Date:</label>
                <input type="date" name="exDate_name" id="exDate_name" required>
            </div>
            <div>
                <label for="cvvPass_name">CVV:</label>
                <input type="password" name="cvvPass_name" id="cvvPass_name" required placeholder="123" minlength="3" maxlength="3">
            </div>
            <input type="submit" value="Pay Now">
            <input type="hidden" name="totalFare" value="<?php echo htmlspecialchars($totalFare); ?>">
            <input type="hidden" name="numPassengers" value="<?php echo htmlspecialchars($numPassengers); ?>">
            <input type="hidden" name="busName" value="<?php echo htmlspecialchars($busData['bus_name']); ?>">
        </form>
    </div>
    </div>
    <script>
        function validate() {
            var pin = document.getElementById("pin_name").value;
            var cardNumber = document.getElementById("cardNumber_name").value;
            var expiryDate = document.getElementById("exDate_name").value;
            var cvv = document.getElementById("cvvPass_name").value;

            if (isNaN(pin) || pin.length != 6) {
                alert("Please enter a valid 6-digit pincode");
                return false;
            }
            if (isNaN(cardNumber) || cardNumber.replace(/-/g, '').length != 16) {
                alert("Please enter a valid 16-digit card number without dashes");
                return false;
            }
            if (isNaN(cvv) || cvv.length != 3) {
                alert("Please enter a valid 3-digit CVV");
                return false;
            }

            var expiry = new Date(expiryDate);
            var currentDate = new Date();
            if (expiry <= currentDate) {
                alert("The card expiry date must be in the future");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
