<?php
ob_start(); // Start output buffering
require_once "config.php"; // Connection script

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect them to home page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index2.php");
    exit;
}

// Variables to hold errors and data
$email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT user_id, email, password FROM user_details WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirect user to home page
                            header("location: index2.php");
                            exit;
                        } else {
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Login System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="login.css">
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
        .container {
            display: flex;
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            height: 100%; /* Full height of the viewport */
            width: 100%; /* Full width of the viewport */
            background-color: #ff6e40;
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
  background-color: #dd2c00;
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
}

.text-danger {
  color: #dc3545;
}

  </style>
</head>
<body>
    <div class="container" id="login-container">
        <div class="form-wrap" id="login-form-wrap">
            <h1 class="login-title">Log In</h1>
            <p class="login-message">Please log in to access your account.</p>
            <form method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
                    <span class="text-danger"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control">
                    <span class="text-danger"><?php echo $password_err; ?></span>
                </div>
                <div class="form-action">
                    <button type="submit" class="btn btn-primary">Log In</button>
                    <a href="forgot-password.php" class="forgot-password-link">Forgot Password?</a>
                </div>
            </form>
            <p class="no-account-message">Don't have an account? <a href="register.php" class="no-account-link">Sign Up</a></p>
        </div>
    </div>

    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var emailError = document.getElementById("email-error");
            var passwordError = document.getElementById("password-error");
            var isValid = true;

            // Clear previous error messages
            emailError.innerText = "";
            passwordError.innerText = "";

            // Email validation
            if (!email) {
                emailError.innerText = "Please enter your email.";
                isValid = false;
            }

            // Password validation
            if (!password) {
                passwordError.innerText = "Please enter your password.";
                isValid = false;
            }

            return isValid;
        }
    </script>
      <script src="script.js"></script>
</body>
</html>