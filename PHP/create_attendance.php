<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = intval($_POST['event']);
    $slot_date = $_POST['slot_date'];
    $slot_time = $_POST['slot_time'];
    $location = trim($_POST['location']);
    $slot_key = trim($_POST['slot_key']);

    // Check if the event already has an attendance slot
    $check_sql = "SELECT * FROM attendance_slots WHERE event_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $event_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('This event already has an attendance slot.'); window.location.href='../CreateAttendanceSlot.php';</script>";
        exit();
    }

    // Insert new attendance slot
    $insert_sql = "INSERT INTO attendance_slots (event_id, slot_date, slot_time, location, slot_key) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("issss", $event_id, $slot_date, $slot_time, $location, $slot_key);

    if ($stmt->execute()) {
        header("Location: ../AttendanceSlotList.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $check_stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
