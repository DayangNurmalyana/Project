<?php
include 'PHP/db_connection.php';

$sql = "SELECT e.*, s.slot_id, s.location AS slot_location
        FROM events e
        LEFT JOIN attendance_slots s ON e.event_id = s.event_id
        ORDER BY e.event_date DESC";

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
        <h1>Events</h1><br>
        <table>
            <tr>
                <th>No</th>
                <th>Event Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Status</th>
                <th>Attendance QR code</th>
            </tr>
            <?php 
$no = 1;
if ($result && $result->num_rows > 0): 
    while ($row = $result->fetch_assoc()): 
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($row['event_name']) ?></td>
    <td><?= htmlspecialchars($row['event_date']) ?></td>
    <td><?= htmlspecialchars($row['event_time']) ?></td>
    <td>
    <?= !empty($row['slot_location']) 
        ? htmlspecialchars($row['slot_location']) 
        : '<em>Not set</em>' ?>
    </td>
    <td><?= htmlspecialchars($row['status']) ?></td>
    <td>
        <?php if (!empty($row['slot_id'])): ?>
            <a href="AttendanceRegister.php?slot_id=<?= $row['slot_id'] ?>">
                <img src="CSS/IMAGES/dummy-qr.png" alt="QR-code" width="100" height="100">
            </a>
        <?php else: ?>
            <em>Not available</em>
        <?php endif; ?>
        </td>
        </tr>
        <?php 
            endwhile; 
        else: 
        ?>
        <tr><td colspan="8">No events found.</td></tr>
        <?php endif; ?>
        </table>
    </div>
</div>
    <!-- bottom footer -->
    <footer><p>©2025 FK. All Rights Reserved.</p></footer>
</body>
</html>