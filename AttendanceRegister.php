<?php
include 'PHP/db_connection.php';

$slot_id = $_GET['slot_id'] ?? null;  // Get slot_id from URL

$eventInfo = null;
$error = '';
$success = '';

// Get event and slot info to display
if ($slot_id) {
    $stmt = $conn->prepare("
        SELECT e.event_name, e.description, a.location, a.slot_key, e.event_id
        FROM attendance_slots a
        JOIN events e ON e.event_id = a.event_id
        WHERE a.slot_id = ?
    ");
    $stmt->bind_param("i", $slot_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $eventInfo = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && $slot_id && $eventInfo) {
    $matricNo = trim($_POST['MatricNo']);
    $entered_key = trim($_POST['slot_key']);

    // Check slot key
    if ($entered_key !== $eventInfo['slot_key']) {
        $error = "Incorrect slot password.";
    } else {
        // Lookup student name
        $stmt = $conn->prepare("SELECT studentName FROM student WHERE matricNo = ?");
        $stmt->bind_param("s", $matricNo);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();
        $stmt->close();

        if ($student) {
            $studentName = $student['studentName'];
            $event_id = $eventInfo['event_id'];

            // Check if already registered
            $check = $conn->prepare("SELECT * FROM attendance WHERE slot_id = ? AND matricNo = ?");
            $check->bind_param("is", $slot_id, $matricNo);
            $check->execute();
            $existing = $check->get_result()->fetch_assoc();
            $check->close();

            if ($existing) {
                $error = "You have already registered your attendance.";
            } else {
                // Insert attendance
                $stmt = $conn->prepare("
                    INSERT INTO attendance (slot_id, event_id, studentID, matricNo, studentName)
                    VALUES (?, ?, 0, ?, ?)
                ");
                $stmt->bind_param("iiss", $slot_id, $event_id, $matricNo, $studentName);
                if ($stmt->execute()) {
                    $success = "Attendance recorded successfully.";
                } else {
                    $error = "Error inserting attendance.";
                }
                $stmt->close();
            }
        } else {
            $error = "Matric number not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="CSS/eventattendance.css">
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
        <h1>Event Attendance Registration</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
        <p style="color:green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Attendance for: <strong><?= htmlspecialchars($eventInfo['event_name'] ?? 'Unknown') ?></strong></label><br><br>

        <label>Location:</label><br>
        <p><?= htmlspecialchars($eventInfo['location'] ?? 'Not available') ?></p><br>

        <label>Event details:</label><br>
        <p><?= htmlspecialchars($eventInfo['description'] ?? 'No description') ?></p><br>

        <label for="matricNo">Matric No:</label><br>
        <input type="text" id="matricNo" name="MatricNo" required><br><br>

        <label for="slot_key">Password:</label><br>
        <input type="text" id="slot_key" name="slot_key" required><br>

        <input type="submit" value="Submit">
        <input class="button" type="button" value="Cancel" onclick="window.location.href='Events_AttendanceCheckinTest.php'">
    </form>
    </div>
</div>

    <!-- bottom footer -->
    <footer style="bottom: 0;"><p>©2025 FK. All Rights Reserved.</p></footer>
</body>
</html>