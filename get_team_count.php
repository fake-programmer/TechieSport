<?php
header('Content-Type: application/json');
require 'db_connect.php';

try {
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM teams");
    $result = $stmt->fetch();

    if ($result) {
        echo json_encode(['success' => true, 'count' => $result['total']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Could not retrieve team count.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to retrieve team count: ' . $e->getMessage()]);
}
?>
