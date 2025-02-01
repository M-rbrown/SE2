<?php 

require_once('db_conn.php'); 

date_default_timezone_set('Asia/Manila');
  // Query to count total residents
  $query = "SELECT COUNT(id) AS total_residents FROM residents"; 
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $totalResidents = $row["total_residents"];

   // Fetch events from the database
   $sql = "SELECT * FROM `event_list` ORDER BY `start_datetime` DESC";
   $result = $conn->query($sql);

?>

<!Doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Diezmo Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- JUST TRY ONLY -->
    <link rel="stylesheet" href="modules/sidebar.css">
  </head>
  
  <?php
    session_start();
    include_once "modules/sidemenu.php";
    include_once "modules/navbar.php";
  ?>

  <body style="background-color: white;">
    <div class="con">
    <div class="left-panel">
      <div class="info-box">Total Residents: 5234</div>
      <a href="resident.php">
        <div class="resi">Registered Residents: <?php echo $totalResidents; ?></div>
      </a>
    </div>
    
    <div class="right-panel">
      <div class="chart-label"><h2>Total Residents each District</h2></div>
      <canvas id="barChart" style="width: 500px; height: 50%;"></canvas>

      <!-- PIE CHART -->
      <div class="chart-Label"><h2>Registered and Total Residents</h2></div>
      <canvas id="pieChart" style="width: 10px; height: 10%;"></canvas>
    </div> 

    <div class="announcements-panel">
      <div class="right-btn">
        <a href="sudden.php">
          <div class="add">Add Announcement</div>
        </a>
      </div>

      <!-- PREVIEW OF ANNOUNCEMENTS -->
      <div class="view">
        <div class="list-group" style="width: 60%; border-radius: 0px;" id="event-list">
          <a href="#" class="list-group-item list-group-item-action" style="background-color: #0d6efd; color: white;">
            <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Announcements</h5>
            </div>
              <!-- <p class="mb-1">Currently displayed announcements.</p> -->
            </a>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()):
                    $start_datetime = new DateTime($row['start_datetime']);
                    $now = new DateTime();
                    $diffInSeconds = $now->getTimestamp() - $start_datetime->getTimestamp();

                    // Calculate elapsed time
                    if ($diffInSeconds <= 0) {
                        $elapsedTime = "Just now";
                    } elseif ($diffInSeconds < 60 && $diffInSeconds > 0) {
                        $elapsedTime = "1 minute ago";
                    } elseif ($diffInSeconds < 3600) {
                        $minutes = floor($diffInSeconds / 60);
                        $elapsedTime = $minutes . " minute(s) ago";
                    } elseif ($diffInSeconds < 86400) { // Less than 24 hours
                        $hours = floor($diffInSeconds / 3600);
                        $elapsedTime = $hours . " hour(s) ago";
                    } else { // 24 hours or more
                        $days = floor($diffInSeconds / 86400);
                        $elapsedTime = $days . " day(s) ago";
                    }

                    // Truncate the description to a maximum of 50 characters
                    $shortDescription = substr($row['description'], 0, 30);
                    if (strlen($row['description']) > 30) {
                        $shortDescription .= "...";
                    }
                    ?>
                    <a href="sudden.php" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?= htmlspecialchars($row['title']); ?></h5>
                            <small><?= $elapsedTime; ?></small>
                        </div>
                        <p class="mb-1"><?= htmlspecialchars($shortDescription); ?></p>
                        <small>Event posted at <?= $start_datetime->format('Y-m-d H:i'); ?></small>
                    </a>
              <?php endwhile; ?>
            <?php else: ?>
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">No Announcements</h5>
                    </div>
                    <p class="mb-1">There are currently no announcements to display.</p>
                </a>
            <?php endif; ?>
            </div>
           </div>

  

   </div>
  </div>
  <!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
     // Bar Chart
const barCtx = document.getElementById('barChart');
new Chart(barCtx, {
  type: 'bar',
  data: {
    labels: ['Baryo', 'Tulay na Bakal', 'Pinag-tagpo', 'Pinag-layo'],
    datasets: [{
      label: '# Total Residents',
      data: [2569, 1658, 952, 513],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
      ],
      borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
      ],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

// Pie Chart
const pieCtx = document.getElementById('pieChart');
new Chart(pieCtx, {
  type: 'pie',
  data: {
    labels: ['Registered Residents', 'Total Population'],
    datasets: [{
      data: [<?php echo $totalResidents; ?>, 5234],
      backgroundColor: [
        'rgb(255, 0, 55)',
        'rgb(6, 192, 0)',
      ],
      borderColor: [
        'rgb(255, 99, 132)',
        'rgb(75, 192, 192)'
      ],
      borderWidth: 0
    }]
  }
});
    </script>
  </body>
</html>
