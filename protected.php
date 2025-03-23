<?php
header('Content-Type: application/json');
require 'db_connect.php';
session_start(); // Start the session

if (isset($_SESSION['user_id'])) {
    // User is logged in
    try {
        $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        if($user) {
            echo json_encode(['success' => true, 'username' => $user['username'], 'message' => 'Access granted.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Could not get user.']);
        }

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to load data: ' . $e->getMessage()]);
    }
} else {
    // User is not logged in
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'message' => 'Unauthorized. Please log in.']);
}
?>
