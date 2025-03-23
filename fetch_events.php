<?php
$servername = "localhost";
$username = "dezmils";
$password = "dezmils";
$dbname = "sports";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, event_type, sport, team, facility, date, time, description FROM events";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $events = array();
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    echo json_encode($events);
} else {
    echo "0 results";
}
$conn->close();
?>