<?php
# Initialize session
session_start();

# Check if the user is already logged in, if yes then redirect him to the welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index2.php");
    exit;
}

# Include connection file
require_once "config.php";

# Define variables and initialize with empty values
$user_login = $user_password = "";
$user_login_err = $user_password_err = $login_err = "";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    # Check if email is empty
    if (empty(trim($_POST["user_login"]))) {
        $user_login_err = "Please enter your email.";
    } else {
        $user_login = trim($_POST["user_login"]);
    }

    # Check if password is empty
    if (empty(trim($_POST["user_password"]))) {
        $user_password_err = "Please enter your password.";
    } else {
        $user_password = trim($_POST["user_password"]);
    }

    # Validate credentials
    if (empty($user_login_err) && empty($user_password_err)) {
        # Prepare a select statement
        $sql = "SELECT user_id, email, password FROM user_details WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            # Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            # Set parameters
            $param_email = $user_login;

            # Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                # Store result
                mysqli_stmt_store_result($stmt);

                # Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    # Bind result variables
                    mysqli_stmt_bind_result($stmt, $user_id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($user_password, $hashed_password)) {
                            # Password is correct, so start a new session
                            session_start();

                            # Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["email"] = $email;                            

                            # Redirect user to welcome page
                            header("location: index2.php");
                        } else {
                            # Display an error message if password is not valid
                            $login_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    # Display an error message if email doesn't exist
                    $login_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@400;500;600;700&display=swap");
        * {
            font-family: 'Barlow Semi Condensed', sans-serif;
            font-weight: 300;
            margin: 0;
        }
        body, html {
            height: 100%; /* Ensure the full height of the window is used */
        }
        body {
            display: flex;
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            height: 100vh; /* Full height of the viewport */
            background-color:#ff9f00;
        }
        .wrapper {
            padding: 40px 30px;
            background: #fefefe;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 360px; /* Adjust width as needed */
        }
        .form-wrap {
            padding: 40px 30px;
            background: #fefefe;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-action {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
        }
        .forgot-password-link {
            margin-left: 20px;
        }
        .no-account-message {
            text-align: center;
            margin-top: 10px;
        }


.form-wrap h1 {
  font-size: 24px;
  font-weight: 600;
  color: #000;
  opacity: 0.85;
}

.form-wrap p {
  line-height: 155%;
  margin-bottom: 5px;
  font-size: 14px;
  color: #000;
  opacity: 0.65;
  font-weight: 400;
  max-width: 200px;
  margin-bottom: 40px;
}

.form-label {
  font-size: 12.5px;
  color: #000;
  opacity: 0.8;
  font-weight: 400;
}

.form-control {
  font-size: 16px;
  padding: 20px 0px;
  height: 56px;
  border: none;
  border-bottom: solid 1px rgba(0, 0, 0, 0.1);
  background: #fff;
  width: 280px;
  box-sizing: border-box;
  transition: all 0.3s linear;
  color: #000;
  font-weight: 400;
  -webkit-appearance: none;
}

.btn-primary {
    width: auto;
    min-width: 100px;
    border-radius: 24px;
    text-align: center;
    padding: 15px 40px;
    margin-top: 5px;
    background-color: #ff4500; /* Darker shade of orange */
    color: #fff;
    font-size: 14px;
    margin-left: auto;
    font-weight: 500;
    box-shadow: 0px 2px 6px -1px rgba(0, 0, 0, 0.13);
    border: none;
    transition: all 0.3s ease;
    outline: 0;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 2px 6px -1px rgba(182, 157, 230, 0.65);
    background-color: #e5690d; /* Hover orange themed */
}

.text-danger {
    color: #dc3545;
}

  </style>

</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="user_login" class="form-control <?php echo (!empty($user_login_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $user_login; ?>">
                <span class="invalid-feedback"><?php echo $user_login_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="user_password" class="form-control <?php echo (!empty($user_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $user_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
        <p>Don't have an account? <a href="register.php">Sign up</a></p>

<!-- Forgot password link -->
<p><a href="forgot_password.php">Forgot password?</a></p>
    </div>    
</body>
</html>
