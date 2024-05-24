<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$userId = $data['userId'];
$name = $data['name'];
$email = $data['email'];

if (!$userId || !$name || !$email) {
    echo json_encode(['message' => 'All fields are required']);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'lab06');

if ($conn->connect_error) {
    echo json_encode(['message' => 'Database connection error']);
    exit;
}

$stmt = $conn->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
$stmt->bind_param('ssi', $name, email, $userId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'User updated successfully']);
} else {
    echo json_encode(['message' => 'Error updating user']);
}

$stmt->close();
$conn->close();
?>


