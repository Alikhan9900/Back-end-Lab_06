<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'lab06');

if ($conn->connect_error) {
    echo json_encode(['message' => 'Database connection error']);
    exit;
}

$result = $conn->query('SELECT id, name, email FROM users');
$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);

$conn->close();
?>
