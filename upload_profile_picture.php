<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kidsbuild";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Check if file was uploaded
if (!isset($_FILES['profilePicture']) || $_FILES['profilePicture']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'No file uploaded or upload error']);
    exit;
}

// Create directory if it doesn't exist
$uploadDir = 'uploads/profile_pictures/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Get file info
$fileName = $_FILES['profilePicture']['name'];
$fileType = $_FILES['profilePicture']['type'];
$fileSize = $_FILES['profilePicture']['size'];
$fileTmpName = $_FILES['profilePicture']['tmp_name'];

// Validate file type
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
if (!in_array($fileType, $allowedTypes)) {
    echo json_encode(['success' => false, 'error' => 'Only JPG, JPEG, PNG, and GIF files are allowed']);
    exit;
}

// Validate file size (max 5MB)
$maxSize = 5 * 1024 * 1024; // 5MB in bytes
if ($fileSize > $maxSize) {
    echo json_encode(['success' => false, 'error' => 'File size must be less than 5MB']);
    exit;
}

// Generate new filename to prevent overwriting existing files
$newFileName = 'user_' . $userId . '_' . time() . '_' . pathinfo($fileName, PATHINFO_EXTENSION);
$targetFilePath = $uploadDir . $newFileName;

// Move uploaded file to target directory
if (move_uploaded_file($fileTmpName, $targetFilePath)) {
    // Update profile picture path in database
    $filePath = $targetFilePath;
    $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
    $stmt->bind_param("si", $filePath, $userId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'filePath' => $filePath]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update database']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to upload file']);
}

$conn->close();
?>