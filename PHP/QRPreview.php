<?php
$slot_id = $_GET['slot_id'];
?>

<!DOCTYPE html>
<html>
<head><title>QR Code Preview</title></head>
<body>
    <h2>Attendance Slot Created</h2>
    <p>Scan this QR code to register attendance:</p>
    <img src="QR/slot_<?= $slot_id ?>.png" alt="QR Code">
    <br><br>
    <a href="AttendanceSlotList.php">Back to List</a>
</body>
</html>
