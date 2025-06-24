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
        <form action="" method="post">
            <label for="event_name">Attendance for event name</label><br><br>

            <label for="location">Location:</label><br>
            <label for="geolocation" id="location" name="location"></label><br><br>

            <label for="description">Event details:</label><br>
            <label for="description" id="description" name="description"></label><br><br>

            <label for="matricNo">Matric No:</label><br>
            <input type="text" id="matricNo" name="MatricNo" required><br><br>

            <label for="slot_key">Password:</label><br>
            <input type="text" id="slot_key" name="slot_key" required><br>

            <input type="submit" value="Submit">
            <input class="button" type="button" value="Cancel" onclick="window.location.href='AttendanceSlotList.php'">
        </form>
    </div>
</div>

    <!-- bottom footer -->
    <footer style="bottom: 0;"><p>©2025 FK. All Rights Reserved.</p></footer>
</body>
</html>