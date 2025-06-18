<?php
$conn = new mysqli("localhost", "root", "", "mypetakom");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT event_id, event_name FROM events ORDER BY event_id DESC";
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

$conn->close();
?>
