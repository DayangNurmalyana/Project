<?php
include 'PHP/db_connection.php';

if (!isset($_GET['slot_id'])) {
    echo "Invalid slot ID.";
    exit();
}

$slot_id = intval($_GET['slot_id']);

// Fetch slot data
$sql = "SELECT a.slot_id, a.slot_date, a.slot_time, a.location, a.slot_key, e.event_name 
        FROM attendance_slots a 
        JOIN events e ON a.event_id = e.event_id 
        WHERE a.slot_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $slot_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Attendance slot not found.";
    exit();
}

$slot = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="CSS/createattendance.css">
    <link rel="icon" type="image/x-icon" href="CSS/IMAGES/petakom-logo.png">
<body>
    <!-- top navigation -->
    <nav class="topbar">
        <ul>
            <li><img src="CSS/IMAGES/fkomlogo.png" alt="UMP-logo" width="70" height="70"></li>
            <li><a href="#home"><img src="CSS/IMAGES/petakom-logo.png" alt="petakom-logo" width="70" height="50"></a></li>
            <li style="margin-left: 0px; padding-top: 15px"><a href="#home"></a><img src="CSS/IMAGES/mypetakom.png" alt="my petakom" width="30%" height="30%"></li>
            <li style="float:right; padding-top: 10px"><a href="#logout" img><img src="CSS/IMAGES/logout.png" alt="logout" width="35" height="35"></a></li>
            <li style="float:right; padding-top: 10px"><a href="#profile"><img src="CSS/IMAGES/profile.png" alt="profile" width="35" height="35"></a></li>
        </ul>
    </nav>
    
<div class="container">
    <!-- side navigation -->
    <nav class="sidebar">
        <ul>
          <li><a href="#usermanagement.html">Profile Management</a></li>
          <li><a href="#eventAdvisor.html">Event Advisor</a></li>
          <li><a href="#stdDashboard.html">Student Dashboard</a></li>
        </ul>
    </nav>

    <!-- content -->
    <div class="box1">
        <h1>Create Attendance Slot</h1>
        <div class="slotform">
        <form action="PHP/update_attendance_slot.php" method="post">
            <input type="hidden" name="slot_id" value="<?= $slot['slot_id'] ?>">

            <label>Event:</label><br>
            <input type="text" value="<?= htmlspecialchars($slot['event_name']) ?>" disabled><br>

            <label for="slot_date">Date:</label><br>
            <input type="date" id="slot_date" name="slot_date" value="<?= $slot['slot_date'] ?>" required><br>

            <label for="slot_time">Time:</label><br>
            <input type="time" id="slot_time" name="slot_time" value="<?= $slot['slot_time'] ?>" required><br>

            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($slot['location']) ?>" required><br>

            <label for="slot_key">Key/Password:</label><br>
            <input type="text" id="slot_key" name="slot_key" value="<?= htmlspecialchars($slot['slot_key']) ?>" required><br>

            <br>
            <input type="submit" class="button" value="Update Slot">
            <input type="button" class="button" value="Cancel" onclick="window.location.href='AttendanceSlotList.php'">
        </form>
        </div>
        <div class="qr">
            <a href="AttendanceRegister.html"><img src="CSS/IMAGES/dummy-qr.png" alt="QR-code" width="100" height="100"></a>
            <br>
            <button type="button">Download</button>
        </div>
    </div>
</div>
    <!-- bottom footer -->
    <footer style="bottom: 0;"><p>©2025 FK. All Rights Reserved.</p></footer>
</body>
</html>