// TWILIO API

<?php
require __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_datetime = $_POST['start_datetime'];  // Not used in SMS

    // Database connection credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "brgy"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission and insert event into database
    if (!empty($title) && !empty($description)) {  // Only check title and description
        // Prepare the SQL query to insert the event data into the database
        $stmt = $conn->prepare("INSERT INTO `event_list` (`title`, `description`, `start_datetime`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $start_datetime);

        // Execute the query and check for success
        if ($stmt->execute()) {
            $message = "Event successfully saved!";
        } else {
            $error = "Database error: " . $conn->error;
        }

        $stmt->close();
    } else {
        $error = "Title and description are required!";
    }

    // Specify the single phone number to send SMS
    $phone_number = '#'; // The phone number to send the SMS to

    // Format the message (title and description only)
    $sms_message = "$title: $description";

    // Twilio API credentials
    $account_sid = 'ACC_SID';
    $auth_token = 'AUTH_TOKEN';
    $twilio_number = 'ACC_#';

    // Create Twilio client
    $client = new \Twilio\Rest\Client($account_sid, $auth_token);

    try {
        // Send the message to the specified phone number
        $client->messages->create(
            $phone_number, // recipient's phone number
            [
                'from' => $twilio_number, // your Twilio number
                'body' => $sms_message // the message content
            ]
        );

        $success_message = 'SMS sent successfully!';
    } catch (Exception $e) {
        $error_message = 'Twilio error: ' . $e->getMessage();
    }

    // Close the database connection
    $conn->close();

    // Display response
    echo "<div style='margin: 20px; padding: 10px; border: 1px solid #ccc;'>";
    echo "<h3>Response:</h3>";
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    if (isset($success_message)) {
        echo "<p style='color: green;'>$success_message</p>";
    }
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    echo "<a href='sudden.php'>Go back</a>";
    echo "</div>";
}
?>
