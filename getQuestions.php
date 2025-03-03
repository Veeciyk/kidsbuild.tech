<?php
header('Content-Type: application/json');
$topic = $_GET['topic']; // Get the topic from the request

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

// Fetch questions for the selected topic
$sql = "SELECT * FROM questions WHERE topic = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $topic);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format options as an array for JSON
        $options = [
            $row['option_a'],
            $row['option_b'],
            $row['option_c'],
            $row['option_d']
        ];
        
        $row['options'] = $options;
        $questions[] = $row;
    }
}

echo json_encode($questions); // Return questions as JSON
$stmt->close();
$conn->close();
?>