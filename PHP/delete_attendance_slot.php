<?php
include 'db_connection.php';

if (isset($_GET['slot_id'])) {
    $slot_id = intval($_GET['slot_id']);

    // Check if slot exists before deleting
    $check_sql = "SELECT * FROM attendance_slots WHERE slot_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $slot_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Proceed with delete
        $delete_sql = "DELETE FROM attendance_slots WHERE slot_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $slot_id);
        
        if ($delete_stmt->execute()) {
            header("Location: ../AttendanceSlotList.php?message=deleted");
            exit();
        } else {
            echo "Error deleting slot: " . $conn->error;
        }

        $delete_stmt->close();
    } else {
        echo "Attendance slot not found.";
    }

    $check_stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
