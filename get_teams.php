<?php
// Database connection details (Replace with your actual credentials)
$servername = "localhost";
$username = "dezmils";
$password = "dezmils";
$dbname = "sports";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the sport from the query string
    $sport = $_GET['sport'] ?? 'football'; // Default to football if not provided

    // Prepare the SQL statement (using prepared statements to prevent SQL injection)
    $stmt = $conn->prepare("SELECT id, team_name, league, coach FROM teams WHERE sport = :sport");
    $stmt->bindParam(':sport', $sport);
    $stmt->execute();

    // Fetch all teams as an associative array
    $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert to JSON and output
    header('Content-Type: application/json'); // Important!  Tells the browser it's JSON
    echo json_encode($teams);

} catch(PDOException $e) {
    http_response_code(5900);  // Set HTTP status code for error
    echo json_encode(['error' => $e->getMessage()]); // Return error as JSON
}

$conn = null; // Close the connection
?>
