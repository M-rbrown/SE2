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
      <h3>Forgot Password</h3>
      <p>Email<span>*</span></p>
      <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box">
      <!-- <p>Password <span>*</span></p>
      <input type="password" name="pass" placeholder="Enter your password" required maxlength="20" class="box"> -->
      
      <!-- Display the error message below the password input field only after form submission -->

      <div class="d-flex justify-content-between">
            <input type="submit" value="Submit" name="submit" class="btn">
            <a href="login.php" class="justify-content-md-end" style="font-size: 20px; margin-left: 280px; color: blue;">Login</a>
        </div>
   </form>
</section>

</body>
</html>