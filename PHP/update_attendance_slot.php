<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slot_id = intval($_POST['slot_id']);
    $slot_date = $_POST['slot_date'];
    $slot_time = $_POST['slot_time'];
    $location = trim($_POST['location']);
    $slot_key = trim($_POST['slot_key']);

    $sql = "UPDATE attendance_slots 
            SET slot_date = ?, slot_time = ?, location = ?, slot_key = ? 
            WHERE slot_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $slot_date, $slot_time, $location, $slot_key, $slot_id);

    if ($stmt->execute()) {
        header("Location: ../AttendanceSlotList.php?message=updated");
        exit();
    } else {
        echo "Update failed: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
