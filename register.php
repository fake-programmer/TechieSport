<?php
header('Content-Type: application/json');
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Basic validation (you should add more robust validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        echo json_encode(['success' => true, 'message' => 'User registered successfully.']);
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            // Check for duplicate username or email
            if (strpos($e->getMessage(), 'username') !== false) {
                echo json_encode(['success' => false, 'message' => 'Username already exists.']);
            } elseif (strpos($e->getMessage(), 'email') !== false) {
                echo json_encode(['success' => false, 'message' => 'Email already exists.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
