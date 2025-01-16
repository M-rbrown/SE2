<?php
session_start();
require 'config.php';  // Ensure the database config is properly included

// Maximum number of allowed attempts
define('MAX_LOGIN_ATTEMPTS', 3);
define('LOCKOUT_TIME', 30); // Lockout time in seconds (5 minutes)

function login($db_con, $email) {
    // Prepare the SQL statement
    $stmt = $db_con->prepare("SELECT * FROM admins WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Fetch the admin record
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Initialize login attempt session variable if not set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// Check if user is locked out
if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
    $remaining = ceil(($_SESSION['lockout_time'] - time()) / 60);
    $error_message = "Too many failed login attempts. Please try again in $remaining minute(s).";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Reset attempts if lockout time expired
    if (isset($_SESSION['lockout_time']) && time() >= $_SESSION['lockout_time']) {
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['lockout_time']);
    }

    // Sanitize input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['pass']);  // Password entered by the admin

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Check if database connection is established
        if ($db_con) {
            // Attempt to log in
            $admin = login($db_con, $email);

            // Check if the admin exists and verify the password
            if ($admin && $password === $admin['password']) {
                // Successful login
                $_SESSION['admins'] = $admin['fname'];
                $_SESSION['email'] = $email;
                $_SESSION['login_attempts'] = 0; // Reset login attempts

                // Redirect to admin dashboard
                header("Location: admin_dashboard.php");
                exit();
            } else {
                // If email or password is incorrect
                $_SESSION['login_attempts']++;

                if ($_SESSION['login_attempts'] >= MAX_LOGIN_ATTEMPTS) {
                    // Lockout user for a specified time
                    $_SESSION['lockout_time'] = time() + LOCKOUT_TIME;
                    $error_message = "Too many failed login attempts. Please try again in 1 minute(s).";
                } else {
                    $error_message = "Invalid email or password. Attempt " . $_SESSION['login_attempts'] . " of " . MAX_LOGIN_ATTEMPTS . ".";
                }
            }
        } else {
            $error_message = "Database connection failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Diezmo Announcements</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- css file link  -->
   <link rel="stylesheet" href="login.css">
</head>
<body style="
  background-image: url('images/login_bg.png'); /* Adjust the path if necessary */
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
">
<section class="form-container">
   <form action="" method="post">
      <h3>Login</h3>
      <p>Email <span>*</span></p>
      <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box">
      <p>Password <span>*</span></p>
      <input type="password" name="pass" placeholder="Enter your password" required maxlength="20" class="box">
      
      <!-- Display the error message below the password input field only after form submission -->
      <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($error_message)): ?>
          <p style="color: red;"><?= htmlspecialchars($error_message); ?></p>
      <?php endif; ?> 

      <div class="d-flex justify-content-between">
            <input type="submit" value="Login" name="submit" class="btn">
            <a href="forgot.php" class="justify-content-md-end" style="font-size: 16px; margin-left: 220px; color: red;">Forgot Password?</a>
        </div>
   </form>
</section>
</body>
</html>
