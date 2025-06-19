<?php
include 'db_connection.php'; // Include your DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values and sanitize them
    $event_id = intval($_POST['event']);
    $slot_date = $_POST['slot_date'];
    $slot_time = $_POST['slot_time'];
    $location = trim($_POST['location']);
    $slot_key = trim($_POST['slot_key']);

    // Validate required fields
    if (empty($event_id) || empty($slot_date) || empty($slot_time) || empty($location) || empty($slot_key)) {
        die("All fields are required.");
    }

    // Prepare SQL insert statement
    $stmt = $conn->prepare("INSERT INTO attendance_slots (event_id, slot_date, slot_time, location, slot_key) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $event_id, $slot_date, $slot_time, $location, $slot_key);

    // Execute and check success
    if ($stmt->execute()) {
        // Optional: redirect to attendance slot list
        header("Location: ../AttendanceSlotList.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
