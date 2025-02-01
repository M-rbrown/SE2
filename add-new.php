<?php
include "db_conn.php";

if (isset($_POST["submit"])) {
   $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name'];
   $gender = $_POST['gender'];
   $location = $_POST['location'];
   $phone = $_POST['phone'];

   $sql = "INSERT INTO `residents`(`id`, `first_name`, `last_name`, `gender`, `location`, `phone`) 
           VALUES (NULL, '$first_name', '$last_name', '$gender', '$location', '$phone')";

   $result = mysqli_query($conn, $sql);

   if ($result) {
      header("Location: resident.php?msg=New record created successfully");
   } else {
      echo "Failed: " . mysqli_error($conn);
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

   <!-- JUST TRY ONLY -->
   <link rel="stylesheet" href="modules/sidebar.css">

   <title>Diezmo Announcements</title>
</head>
<?php 
    include_once "modules/navbar.php"; 
    include_once "modules/sidemenu.php";
    ?>
<body>

   <div class="container" style="color: black; background-color: white; width: auto; margin-right: 20px; margin-left: 300px; margin-top: 50px; padding: 6px;border-radius: 5px;height: auto;">
      <div class="text-center mb-3">
         <h3>Add Resident</h3>
         <p class="text-muted">Complete the form below to add Resident</p>
      </div>
      <div class="container">
         <form action="" method="post" style="width:100%; min-width:300px;">
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">First Name:</label>
                  <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
               </div>

               <div class="col">
                  <label class="form-label">Last Name:</label>
                  <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
               </div>
            </div>

            <div class="form-group mb-3">
               <label>Gender:</label>
               &nbsp;
               <input type="radio" class="form-check-input" name="gender" id="Male" value="Male" required>
               <label for="Male" class="form-input-label">Male</label>
               &nbsp;
               <input type="radio" class="form-check-input" name="gender" id="Female" value="Female" required>
               <label for="Female" class="form-input-label">Female</label>
            </div>

            <div class="mb-3">
               <label class="form-label">Location:</label>
               <select class="form-select" name="location" required>
                  <option value="" disabled selected>Select your location</option>
                  <option value="Baryo">Baryo</option>
                  <option value="Tulay na Bakal">Tulay na Bakal</option>
                  <option value="Pinag-tagpo">Pinag-tagpo</option>
                  <option value="Pinag-layo">Pinag-layo</option>
               </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Phone Number:</label>
              <div class="input-group">
                  <span class="input-group-text" id="addon-wrapping">+63</span>
                  <input type="tel" class="form-control" name="phone" placeholder="923-456-7890" required id="phone">
              </div>
              <small class="form-text text-muted">Format: 923-456-7890</small>
            </div>
            <div>
               <button type="submit" class="btn btn-success" name="submit">Save</button>
               <a href="resident.php" class="btn btn-danger">Cancel</a>
            </div>
         </form>
      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
   <script>
//    document.getElementById('phone').addEventListener('input', function (e) {
//     var value = e.target.value.replace(/\D/g, ''); // Remove all non-numeric characters
//     if (value.length > 3 && value.length <= 6) {
//         e.target.value = value.slice(0, 3) + '-' + value.slice(3);
//     } else if (value.length > 6) {
//         e.target.value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
//     } else {
//         e.target.value = value;
//     }
// });
      document.getElementById('phone').addEventListener('input', function (e) {
         var value = e.target.value.replace(/\D/g, ''); // Remove all non-numeric characters
         if (value.length > 11) {
            value = value.slice(0, 11); // Limit to 11 characters
         }
         e.target.value = value; // Set the sanitized value back to the input
      });
   </script>

</body>
</html>
