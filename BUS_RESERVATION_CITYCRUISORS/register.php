<?php
session_start();
# Include connection
require_once "./config.php";

# Define variables and initialize with empty values
$name_err = $email_err = $password_err = "";
$name = $email = $password = "";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    # Validate email 
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } else {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Please enter a valid email address.";
        }
    }

    # Validate password 
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    # Check input errors before inserting into database
    if (empty($name_err) && empty($email_err) && empty($password_err)) {
        # Prepare an insert statement
        $sql = "INSERT INTO user_details (name, email, password) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            # Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_password);

            # Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); # Hash password

            # Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                # Redirect to login page
                header("location: login_page.php");
                exit;
            } else {
                echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
            }

            # Close statement
            mysqli_stmt_close($stmt);
        }
    }

    # Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
    <script defer src="./js/script.js"></script>
   <style>
  /* Custom CSS for cleaner orange-themed styling with image overlay */
 /* Custom CSS for advanced orange-themed styling */

body {
    font-family: 'Arial', sans-serif;
    color: black;
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #ff9f00; /* Light orange background */
}

.container {
    background-color: transparent; /* Transparent background */
}

.form-wrap {
    background-color: #fff; /* White background for form */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px; /* Optimal width for form */
    padding: 40px;
    transition: transform 0.3s ease; /* Smooth transition */
}

.form-wrap:hover {
    transform: translateY(-5px); /* Hover effect - lift up slightly */
}

.form-wrap h1 {
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

.form-wrap p {
    font-size: 16px;
    text-align: center;
    color: #666;
    margin-bottom: 20px;
}

.form-label {
    margin-bottom: 5px;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 10px;
    transition: border-color 0.3s ease; /* Smooth transition */
}

.form-control:focus {
    outline: none;
    border-color: #f58220; /* Orange border color on focus */
    box-shadow: 0 0 0 2px rgba(245, 130, 32, 0.2); /* Orange border glow on focus */
}

.text-danger {
    color: #dc3545;
    font-size: 12px;
}

.btn-primary {
    width: 100%;
    padding: 10px;
    background-color: #ff4500; /* Orange button */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Smooth transition */
}

.btn-primary:hover {
    background-color: #e5690d; /* Darker shade of orange on hover */
}

.form-check-input:checked + .form-check-label::before {
    background-color: #f58220;
    border-color: #f58220;
}

.form-check-label {
    user-select: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .form-wrap {
        padding: 20px;
        max-width: 90%; /* More screen space on smaller devices */
    }
}

</style>
</head>

<body>
    <div class="container">
    <div class="row min-vh-100 justify-content-center align-items-center">
            <div class="col-lg-5">
                <div class="form-wrap border rounded p-4">
                    <h1>Sign up</h1>
                    <p>Please fill this form to register</p>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="<?= htmlspecialchars($name); ?>">
                            <small class="text-danger"><?= $name_err; ?></small>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="<?= htmlspecialchars($email); ?>">
                            <small class="text-danger"><?= $email_err; ?></small>
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <small class="text-danger"><?= $password_err; ?></small>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="togglePassword">
                            <label for="togglePassword" class="form-check-label">Show Password</label>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-primary form-control" name="submit" value="Sign Up">
                        </div>

                        <p class="mb-0">Already have an account? <a href="login_page.php">Log In</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
