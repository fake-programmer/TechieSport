<?php
header('Content-Type: application/json');
require 'db_connect.php';

try {
    $stmt = $pdo->query("SELECT id, team_name FROM teams");
    $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $options = '';
    foreach ($teams as $team) {
        $options .= '<option value="' . htmlspecialchars($team['id']) . '">' . htmlspecialchars($team['team_name']) . '</option>';
    }

    echo json_encode(['success' => true, 'options' => $options]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch teams: ' . $e->getMessage()]);
}
?>
