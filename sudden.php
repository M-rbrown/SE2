<?php
require_once('db_conn.php');

date_default_timezone_set('Asia/Manila');

// Fetch events from the database that are less than 7 days old
$sql = "SELECT * FROM `event_list` WHERE `start_datetime` >= NOW() - INTERVAL 7 DAY ORDER BY `start_datetime` DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diezmo Announcements</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <?php
        session_start();
        include_once "modules/sdn.php";
        include_once "modules/navbar.php";
    ?>
    <div class="container py-5" style="margin-left: 295px">
        <div class="row" style="width: 1550px;">
            <!-- List Group Section -->
            <div class="col-md-6">
                <div class="d-flex justify-content-center">
                    <div class="list-group" style="width: 100%; border-radius: 0px;" id="event-list">
                        <a href="#" class="list-group-item list-group-item-action" style="background-color: #0d6efd; color: white;">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Announcements</h5>
                            </div>
                            <p class="mb-1">Currently displayed announcements.</p>
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
                            ?>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?= htmlspecialchars($row['title']); ?></h5>
                                    <small><?= $elapsedTime; ?></small>
                                </div>
                                <p class="mb-1"><?= htmlspecialchars($row['description']); ?></p>
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

        
        <!-- Event Form Section -->
        <div class="col-md-6">
            <div class="cardt rounded-0 shadow" style="width: 240px">
                <div class="card-header" style="background-color: #0d6efd; color: white">
                    <h5 class="card-title">Set Announcement</h5>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <form action="send_sms.php" method="post" id="schedule-form">
                            <div class="form-group mb-2">
                                <label for="title" class="control-label">Announcement Type</label>
                                <select class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                    <option value="Disaster">Disaster</option>
                                    <option value="Emergency">Emergency</option>
                                    <option value="Announcement">Announcement</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="description" class="control-label">Details</label>
                                <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="start_datetime" class="control-label">Start</label>
                                <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                            </div>
                            <!-- <div class="form-group mb-2">
                                <label for="number" class="control-label">Phone Number</label>
                                <input type="text" class="form-control form-control-sm rounded-0" name="number" id="number" placeholder="Enter phone number" required>
                            </div> -->
                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form" id="submit">
                            <i class="fa fa-save"></i> Save & Send
                        </button>
                        <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form">
                            <i class="fa fa-reset"></i> Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


<script>
    // Function to format date for datetime-local input
    function formatDateTime(date) {
        return date.toISOString().slice(0, 16); 
    }

    // Function to set minimum date for the datetime input
    function setMinDates() {
        const now = new Date();
        const formattedDate = formatDateTime(now);

        const start_datetime = document.getElementById("start_datetime");
        start_datetime.setAttribute("min", formattedDate);
    }

    // // Average loading to make the script and other functions run
    // window.onload = setMinDates;

    // Fast loading of functions
    document.addEventListener('DOMContentLoaded', function() {
        setMinDates();
        });
</script>


</body>
</html> 
