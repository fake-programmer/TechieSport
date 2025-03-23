<?php
header('Content-Type: application/json');
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $teamName = $data['team_name'];
    $sport = $data['sport'];
    $league = $data['league'];
    $coach = $data['coach'];

    if (empty($teamName) || empty($sport) || empty($league) || empty($coach)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO teams (team_name, sport, league, coach) VALUES (?, ?, ?, ?)");
        $stmt->execute([$teamName, $sport, $league, $coach]);

        echo json_encode(['success' => true, 'message' => 'Team registered successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
