<?php
include "db_conn.php";

// Retrieve search and location parameters from URL
$search = isset($_GET['search']) ? $_GET['search'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Prepare the SQL query with filters
$sql = "SELECT * FROM `residents` WHERE 1";

// Add search filter if provided
if (!empty($search)) {
    $sql .= " AND (first_name LIKE '%$search%' OR last_name LIKE '%$search%')";
}

// Add location filter if selected
if (!empty($location)) {
    $sql .= " AND location = '$location'";
}

$result = mysqli_query($conn, $sql);
$rowNumber = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- Bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

      <title>Diezmo Announcements</title>
</head>

<?php 
    include_once "modules/navbar.php"; 
    include_once "modules/resident_list.php"; 
    ?>
<body style="background-color: #eee;">
  <!-- Navbar and other content -->
 

  <!-- <div class="container" style="width: 1000px; margin-left: 280px; padding-top: 50px;"> -->
    <div class="container" style="width: auto; margin-left: 293px; margin-top: 20px; padding: 6px;border-radius: 5px;height: auto;">
    <!-- Search and Filter Form -->

    <div class="container">
    <?php
    if (isset($_GET["msg"])) 
    {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>

<div class="container" style="width: auto; margin: 20px 20px 0px 0px; padding: 6px;">
  <div class="d-flex justify-content-between mb-3">
    <form method="GET" action="" class="d-flex w-100">
      <!-- Search Bar -->
      <input type="text" name="search" class="form-control me-3" placeholder="Search..." style="max-width: 300px;" value="<?php echo htmlspecialchars($search); ?>">

      <!-- Location Dropdown -->
      <select name="location" class="form-select me-3" style="max-width: 200px;" onchange="this.form.submit()">
        <option value="" disabled selected>Filter by Location</option>
        <option value="" <?php if ($location == '') echo 'selected'; ?>>All District</option>
        <option value="Baryo" <?php if ($location == 'Baryo') echo 'selected'; ?>>Baryo</option>
        <option value="Tulay na Bakal" <?php if ($location == 'Tulay na Bakal') echo 'selected'; ?>>Tulay na Bakal</option>
        <option value="Pinag-tagpo" <?php if ($location == 'Pinag-tagpo') echo 'selected'; ?>>Pinag-tagpo</option>
        <option value="Pinag-layo" <?php if ($location == 'Pinag-layo') echo 'selected'; ?>>Pinag-layo</option>
      </select>

      <!-- Add New Button -->
      <a href="add-new.php" class="btn btn-dark ms-auto" style="background-color: #0d6efd; border-color: #0d6efd;">Add New</a>
    </form>
  </div>
</div>

<!-- Table Container with Background -->
<div class="container" style="background-color: white; width: auto; padding: 6px; margin-right: 20px; margin-left: 0px; margin-top: 0px;">
  <table class="table table-hover text-center">
  <thead style="background-color: #0d6efd; color: white;">
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Gender</th>
        <th>Location</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
            <td><?php echo $rowNumber++; ?></td> <!-- Display row number -->
              <td><?php echo $row["first_name"]; ?></td>
              <td><?php echo $row["last_name"]; ?></td>
              <td><?php echo $row["phone"]; ?></td>
              <td><?php echo $row["gender"]; ?></td>
              <td><?php echo $row["location"]; ?></td>
              <td>
                <a href="edit.php?id=<?php echo $row["id"]; ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                <a href="delete.php?id=<?php echo $row["id"]; ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<tr><td colspan='7'>No records found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>
