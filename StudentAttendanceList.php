<?php
include 'PHP/db_connection.php';

if (!isset($_GET['slot_id'])) {
    echo "Slot ID not provided.";
    exit;
}

$slot_id = intval($_GET['slot_id']);

// Fetch event name for display (optional)
$event_sql = "SELECT e.event_name 
              FROM attendance_slots a 
              JOIN events e ON a.event_id = e.event_id 
              WHERE a.slot_id = ?";
$event_stmt = $conn->prepare($event_sql);
$event_stmt->bind_param("i", $slot_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();
$event_name = "Unknown Event";

if ($event_result && $event_row = $event_result->fetch_assoc()) {
    $event_name = $event_row['event_name'];
}

// Fetch student attendance for that slot
$attendance_sql = "SELECT studentID, studentName, matricNo, attendance_time 
                   FROM attendance 
                   WHERE slot_id = ?";
$stmt = $conn->prepare($attendance_sql);
$stmt->bind_param("i", $slot_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="CSS/studentlist.css">
    <link rel="icon" type="image/x-icon" href="CSS/IMAGES/petakom-logo.png">
<body>
    <!-- top navigation -->
    <nav class="topbar">
        <ul>
            <li><img src="CSS/IMAGES/fkomlogo.png" alt="UMP-logo" width="70" height="70"></li>
            <li><a href="#home"><img src="CSS/IMAGES/petakom-logo.png" alt="petakom-logo" width="70" height="50"></a></li>
            <li style="margin-left: 0px; padding-top: 15px"><a href="#home"></a><img src="CSS/IMAGES/mypetakom.png" alt="my petakom" width="30%" height="30%"></li>
            <li style="float:right; padding-top: 10px"><a href="#logout"><img src="CSS/IMAGES/logout.png" alt="logout" width="35" height="35"></a></li>
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
    <div class="rcorners1">
        <h1>Student Attendance List for <?= htmlspecialchars($event_name) ?></h1>
        <table>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Matric ID</th>
                <th>Check-In Time</th>
            </tr>
            <?php
                $no = 1;
                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['studentName']) ?></td>
                    <td><?= htmlspecialchars($row['matricNo']) ?></td>
                    <td><?= htmlspecialchars($row['attendance_time']) ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="4">No attendance records found.</td>
                </tr>
            <?php endif; ?>
        </table>
        <br>
        <input class="button" type="button" value="Back to Slot List" onclick="window.location.href='AttendanceSlotList.php'">
    </div>
</div>

<footer><p>©2025 FK. All Rights Reserved.</p></footer>
</body>
</html>
