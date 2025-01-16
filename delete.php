<?php
include "db_conn.php";

// Check if 'id' is set in the URL and is a valid number
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = intval($_GET["id"]);
    $sql = "DELETE FROM `residents` WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: resident.php?msg=Data deleted successfully");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
} else {
    // Redirect back with an error message or handle the missing ID
    header("Location: resident.php?msg=Invalid or missing ID");
    exit();
}
