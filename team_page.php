<?php
// Check if team_id is set
if (isset($_GET['team_id']) && is_numeric($_GET['team_id'])) {
    $team_id = (int)$_GET['team_id']; // Sanitize the input

    // Database connection details (Replace with your actual credentials)
    $servername = "localhost";
    $username = "dezmils";
    $password = "dezmils";
    $dbname = "sports";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT team_name, league, coach FROM teams WHERE id = :team_id");
        $stmt->bindParam(':team_id', $team_id, PDO::PARAM_INT); // Bind as an integer
        $stmt->execute();

        $team = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($team) {
            // Display team information
            echo "<h1>Team: " . htmlspecialchars($team['team_name']) . "</h1>";
            echo "<p>League: " . htmlspecialchars($team['league']) . "</p>";
            echo "<p>Coach: " . htmlspecialchars($team['coach']) . "</p>";
            // Add more team details here
        } else {
            echo "Team not found.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

} else {
    echo "Invalid team ID.";
}
?>
