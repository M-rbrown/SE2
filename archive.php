<?php
require_once('db_conn.php');

date_default_timezone_set('Asia/Manila');

// Fetch expired events (events older than 7 days)
$expired_sql = "SELECT * FROM `event_list` WHERE `start_datetime` < NOW() - INTERVAL 7 DAY ORDER BY `start_datetime` DESC";
$expired_result = $conn->query($expired_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Diezmo Announcements</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <!-- JUST TRY ONLY -->
 <link rel="stylesheet" href="modules/sidebar.css">

</head>
<body>
<?php
    session_start();
    include_once "modules/navbar.php";
    include_once "modules/sidemenu.php";
?>
<div class="container py-5" style="margin-left: 295px">
    <div class="row" style="width: 1050px;">
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
                <div class="list-group" style="width: 100%; border-radius: 0px;" id="expired-event-list">
                    <a href="#" class="list-group-item list-group-item-action" style="background-color: #dc3545; color: white;">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">All Announcements Completed</h5>
                        </div>
                        <p class="mb-1">Announcements older than 7 days have already been conducted.</p>
                    </a>
                    <?php if ($expired_result && $expired_result->num_rows > 0): ?>
                        <?php while ($row = $expired_result->fetch_assoc()): ?>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><?= htmlspecialchars($row['title']); ?></h5>
                                <small>Done</small>
                            </div>
                            <p class="mb-1"><?= htmlspecialchars($row['description']); ?></p>
                            <small>Event posted at <?= (new DateTime($row['start_datetime']))->format('Y-m-d H:i'); ?></small>
                        </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">No Finalized Announcements</h5>
                                </div>
                                    <p class="mb-1">There are currently no completed announcements.</p>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
