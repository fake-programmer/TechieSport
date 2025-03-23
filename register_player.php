<?php
header('Content-Type: application/json');
require 'db_connect.php'; // Include your database connection

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate data (very important)
    if (!isset($data['player_name']) || empty($data['player_name'])) {
        echo json_encode(['success' => false, 'message' => 'Player name is required']);
        exit;
    }

    // Prepare and execute the SQL query
    try {
        $sql = "INSERT INTO players (team_id, player_name, admission_number, year_of_study, position)
                VALUES (:team_id, :player_name, :admission_number, :year_of_study, :position)";

        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':team_id', $data['team_id']);
        $stmt->bindParam(':player_name', $data['player_name']);
        $stmt->bindParam(':admission_number', $data['admission_number']);
        $stmt->bindParam(':year_of_study', $data['year_of_study']);
        $stmt->bindParam(':position', $data['position']);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Player registered successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to register player']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
