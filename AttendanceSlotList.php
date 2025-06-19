<?php
include 'PHP/db_connection.php';

// Fetch all attendance slots with corresponding event name
$sql = "SELECT a.slot_id, e.event_name, a.slot_date, a.slot_time, a.location, a.slot_key
        FROM attendance_slots a
        JOIN events e ON a.event_id = e.event_id
        ORDER BY a.slot_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="CSS/slotlist.css">
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
    <div class="rcorners1">
        <h1>Attendance Slot List</h1>
        <button class="button1" onclick="window.location.href='CreateAttendanceSlot.php'">Create New Slot</button>
        <table>
            <tr>
                <th>No</th>
                <th>Event Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Key</th>
                <th>Actions</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): 
                $no = 1;
                while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><a href="StudentAttendanceList.php?slot_id=<?= $row['slot_id'] ?>"><?= htmlspecialchars($row['event_name']) ?></a></td>
                    <td><?= htmlspecialchars($row['slot_date']) ?></td>
                    <td><?= htmlspecialchars($row['slot_time']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= htmlspecialchars($row['slot_key']) ?></td>
                    <td>
                        <a href="EditAttendanceSlot.php?slot_id=<?= $row['slot_id'] ?>"><button class="button2">Edit</button></a>
                        <a href="PHP/delete_attendance_slot.php?slot_id=<?= $row['slot_id'] ?>" onclick="return confirm('Are you sure you want to delete this slot?');"><button class="button3">Delete</button></a>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="7">No attendance slots found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</div>
    <!-- bottom footer -->
    <footer><p>©2025 FK. All Rights Reserved.</p></footer>
</body>
</html>