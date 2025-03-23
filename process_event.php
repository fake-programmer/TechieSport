<?php
$servername = "localhost"; // Change if necessary
$username = "dezmils"; // Change if necessary
$password = "dezmils"; // Change if necessary
$dbname = "sports"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding an event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_type = $_POST['event_type'];
    $sport = $_POST['sport'];
    $team = $_POST['team'];
    $facility = $_POST['facility'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $description = $_POST['description'];

    $sql = "INSERT INTO events (event_type, sport, team, facility, date, time, description) VALUES ('$event_type', '$sport', '$team', '$facility', '$date', '$time', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "New event created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle retrieving events
$sql = "SELECT * FROM events";
$result = $conn->query($sql);
$events = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

$conn->close();
?>