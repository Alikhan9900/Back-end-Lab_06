<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'];
$password = $data['password'];

if (!$email || !$password) {
    echo json_encode(['message' => 'All fields are required']);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'lab06');

if ($conn->connect_error) {
    echo json_encode(['message' => 'Database connection error']);
    exit;
}

$stmt = $conn->prepare('SELECT id, password FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    echo json_encode(['message' => 'Invalid email or password']);
    $stmt->close();
    $conn->close();
    exit;
}

$stmt->bind_result($id, $hashedPassword);
$stmt->fetch();

if (password_verify($password, $hashedPassword)) {
    echo json_encode(['message' => 'Login successful', 'userId' => $id]);
} else {
    echo json_encode(['message' => 'Invalid email or password']);
}

$stmt->close();
$conn->close();
?>
