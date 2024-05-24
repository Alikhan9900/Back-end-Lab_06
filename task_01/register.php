
<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$email = $data['email'];
$password = $data['password'];

if (!$name || !$email || !$password) {
    echo json_encode(['message' => 'All fields are required']);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'lab06');

if ($conn->connect_error) {
    echo json_encode(['message' => 'Database connection error']);
    exit;
}

$emailCheck = $conn->prepare('SELECT id FROM users WHERE email = ?');
$emailCheck->bind_param('s', $email);
$emailCheck->execute();
$emailCheck->store_result();

if ($emailCheck->num_rows > 0) {
    echo json_encode(['message' => 'Email already in use']);
    $emailCheck->close();
    $conn->close();
    exit;
}

$emailCheck->close();

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$stmt = $conn->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $name, $email, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(['message' => 'User registered successfully']);
} else {
    echo json_encode(['message' => 'Error registering user']);
}

$stmt->close();
$conn->close();
?>
