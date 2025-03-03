<?php
session_start();
header('Content-Type: application/json');

// Get data from the request
$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id']; // Get user ID from session
$topic = $data['topic'];
$score = $data['score'];
$totalQuestions = $data['totalQuestions'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kidsbuild";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Save score to the database - added the missing parenthesis and user_id field
$sql = "INSERT INTO scores (user_id, topic, score, total_questions, date_taken) 
        VALUES ('$user_id', '$topic', $score, $totalQuestions, NOW())";

if ($conn->query($sql)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$conn->close();
?>