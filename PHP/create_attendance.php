<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "mypetakom");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize input
$event_id = $_POST['event_id'];
$slot_date = $_POST['slot_date'];
$slot_time = $_POST['slot_time'];
$location = $conn->real_escape_string($_POST['location']);
$slot_key = password_hash($_POST['slot_key'], PASSWORD_BCRYPT); // Hash the key for security

// Insert into DB
$sql = "INSERT INTO attendance_slots (event_id, slot_date, slot_time, location, slot_key)
        VALUES ('$event_id', '$slot_date', '$slot_time', '$location', '$slot_key')";

if ($conn->query($sql) === TRUE) {
    echo "Attendance slot created successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>