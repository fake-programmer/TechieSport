<?php
header('Content-Type: application/json');
session_start(); // Start the session

session_unset();  // Remove all session variables
session_destroy(); // Destroy the session

echo json_encode(['success' => true, 'message' => 'Logged out successfully.']);
?>
