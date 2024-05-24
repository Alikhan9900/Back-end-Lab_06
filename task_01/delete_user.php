<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$userId = $data['userId'];

if (!$userId) {
    echo json_encode(['message' => 'User ID is required']);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'lab06');

if ($conn->connect_error) {
    echo json_encode(['message' => 'Database connection error']);
    exit;
}

$stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
$stmt->bind_param('i', $userId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'User deleted successfully']);
} else {
    echo json_encode(['message' => 'Error deleting user']);
}

$stmt->close();
$conn->close();
?>

