<?php
// Replace with your actual DB credentials
$conn = new mysqli("localhost", "root", "", "mypetakom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT attendance_slots.slot_id, events.event_name AS event_name, slot_date, slot_time, location, slot_key
        FROM attendance_slots
        JOIN events ON attendance_slots.event_id = events.id
        ORDER BY slot_date DESC, slot_time DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
        echo "<td>{$row['slot_date']}</td>";
        echo "<td>{$row['slot_time']}</td>";
        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
        echo "<td>" . htmlspecialchars($row['slot_key']) . "</td>";
        echo "<td>
                <a href='edit_attendance_slot.php?id={$row['id']}'>Edit</a> |
                <a href='delete_attendance_slot.php?id={$row['id']}' onclick='return confirm(\"Delete this slot?\")'>Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No attendance slots found.</td></tr>";
}

$conn->close();
?>
