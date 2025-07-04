<?php
include 'PHP/db_connection.php';

// Get events that don't already have attendance slots
$events = [];
$sql = "SELECT e.event_id, e.event_name 
        FROM events e
        WHERE NOT EXISTS (
            SELECT 1 FROM attendance_slots a WHERE a.event_id = e.event_id
        )";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
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
        <form action="PHP/create_attendance.php" method="post">
            <label for="event">Select Event:</label><br>
            <select id="event" name="event" required>
                        <option value="">--Choose an Event--</option>
                        <?php foreach ($events as $event): ?>
                            <option value="<?= $event['event_id'] ?>">
                                <?= htmlspecialchars($event['event_name']) ?>
                            </option>
                        <?php endforeach; ?>
            </select><br>

            <label for="slot_date">Date:</label><br>
            <input type="date" id="slot_date" name="slot_date" required><br>

            <label for="slot_time">Time:</label><br>
            <input type="time" id="slot_time" name="slot_time" required><br>

            <label for="location">Location (Geolocation):</label><br>
            <input type="text" id="location" name="location" placeholder="e.g. FK Block C, UMPSA" required><br>

            <label for="slot_key">Key/Password:</label><br>
            <input type="text" id="slot_key" name="slot_key" placeholder="e.g. abc123" required><br>

            <br>
            <input style="margin-left: 60%;" class="button" type="submit" value="Create Slot">
            <input class="button" type="button" value="Cancel" onclick="window.location.href='AttendanceSlotList.php'">
        </form>
        </div>
        <div class="qr">
            <a href="AttendanceRegister.php"><img src="CSS/IMAGES/dummy-qr.png" alt="QR-code" width="100" height="100"></a>
            <br>
            <button type="button">Download</button>
        </div>
    </div>
</div>
    <!-- bottom footer -->
    <footer style="bottom: 0;"><p>©2025 FK. All Rights Reserved.</p></footer>
</body>
</html>