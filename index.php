<?php require_once('db-connect.php') ?>
    
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diezmo Announcements</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fullcalendar/lib/main.min.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="fullcalendar/lib/main.min.js"></script>
    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
            --poppins: 'Poppins', sans-serif;
            --lato: 'Lato', sans-serif;
        }

        body {
            height: 100%;
            width: 100%;
            font-family: var(--poppins, --lato);
        }

        .container-wrap {
        background-color: #eee;
        /* padding-top: 3vh; */
        padding-left: 22%;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }
        table, tbody, td, tfoot, th, thead, tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
            background-color: white;
        }
    </style>
</head>
    <?php 
    include_once "modules/navbar.php"; 
    include_once "modules/btn-active.php"; 
    ?>
<body class="bg-light">

    <div class="container-wrap">
        <div class="container py-5" id="page-container">
            <div class="row">
                <div class="col-md-9">
                    <div id="calendar"></div>
                </div>
                <div class="col-md-3">
                    <div class="cardt rounded-0 shadow">
                        <div class="card-header" style="background-color: #0d6efd; color: white">
                            <h5 class="card-title">Set Event</h5>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <form action="save_schedule.php" method="post" id="schedule-form">
                                    <input type="hidden" name="id" value="">
                                    <div class="form-group mb-2">
                                        <label for="title" class="control-label">Title</label>
                                        <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="description" class="control-label">Details</label>
                                        <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="start_datetime" class="control-label">Start</label>
                                        <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required min="">
                                    </div>
                                    <div class="form-group mb-2">   
                                        <label for="end_datetime" class="control-label">End</label>
                                        <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required min="">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Title</dt>
                            <dd id="title" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Description</dt>
                            <dd id="description" class=""></dd>
                            <dt class="text-muted">Start</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">End</dt>
                            <dd id="end" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Event</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="save_schedule.php" method="post" id="edit-form">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-title" class="control-label">Title</label>
                        <input type="text" class="form-control form-control-sm rounded-0" name="title" id="edit-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-description" class="control-label">Description</label>
                        <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="edit-description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-start" class="control-label">Start</label>
                        <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="edit-start" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-end" class="control-label">End</label>
                        <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="edit-end" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="edit-form" class="btn btn-primary rounded-0"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<?php 
$schedules = $conn->query("SELECT * FROM `schedule_list`");
$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
}
?>
<?php 
if(isset($conn)) $conn->close();
?>
</body>

<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>

<script src="./js/script.js"></script>

<script>
    // Function to format date for datetime-local input
    function formatDateTime(date) {
        return date.toISOString().slice(0, 16);
    }

    // Function to set minimum dates for datetime inputs
    function setMinDates() {
        const now = new Date();
        const formattedDate = formatDateTime(now);

        // For main form
        const startDatetime = document.getElementById("start_datetime");
        const endDatetime = document.getElementById("end_datetime");
        
        // For edit modal
        const editStart = document.getElementById("edit-start");
        const editEnd = document.getElementById("edit-end");

        // Set up main form constraints
        if (startDatetime && endDatetime) {
            startDatetime.setAttribute("min", formattedDate);
            
            startDatetime.addEventListener("change", function() {
                // Clear end date if it's before start date
                if (endDatetime.value && endDatetime.value < startDatetime.value) {
                    endDatetime.value = '';
                }
                endDatetime.setAttribute("min", startDatetime.value);
            });

            endDatetime.addEventListener("change", function() {
                if (this.value < startDatetime.value) {
                    alert("End date cannot be before start date");
                    this.value = startDatetime.value;
                }
            });
        }

        // Set up edit modal constraints
        if (editStart && editEnd) {
            editStart.setAttribute("min", formattedDate);
            
            editStart.addEventListener("change", function() {
                // Clear end date if it's before start date
                if (editEnd.value && editEnd.value < editStart.value) {
                    editEnd.value = '';
                }
                editEnd.setAttribute("min", editStart.value);
            });

            editEnd.addEventListener("change", function() {
                if (this.value < editStart.value) {
                    alert("End date cannot be before start date");
                    this.value = editStart.value;
                }
            });
        }
    }

    // Run when document loads
    document.addEventListener('DOMContentLoaded', function() {
        setMinDates();
    });

    // Run when edit modal is shown
    document.getElementById('editModal').addEventListener('shown.bs.modal', function () {
        setMinDates();
    });
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the modals
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    const eventDetailsModal = document.getElementById('event-details-modal');

    // Handle edit button click
    document.getElementById('edit').addEventListener('click', function() {
        const eventId = this.getAttribute('data-id');
        const event = scheds[eventId];
        
        if (event) {
            // Fill the edit form fields
            document.getElementById('edit-id').value = eventId;
            document.getElementById('edit-title').value = event.title;
            document.getElementById('edit-description').value = event.description;
            document.getElementById('edit-start').value = event.start_datetime.replace(" ", "T");
            document.getElementById('edit-end').value = event.end_datetime.replace(" ", "T");
            
            // Close the event details modal using jQuery
            $('#event-details-modal').modal('hide');
            
            // Small delay before showing edit modal
            setTimeout(() => {
                editModal.show();
            }, 100);
        }
    });

    // When edit modal is hidden, reset the form
    document.getElementById('editModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('edit-form').reset();
    });


    // Optional: Add form submission handling if you want to handle it via AJAX
    document.getElementById('edit-form').addEventListener('submit', function(e) {
        // If you want to handle the submission via regular form POST, 
        // remove this event listener entirely
        
        // If you want to prevent the default form submission and handle it via AJAX:
        /* 
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('save_schedule.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Close modal and refresh calendar
            editModal.hide();
            // Refresh your calendar here
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
        */
    });
});
</script>

</html>