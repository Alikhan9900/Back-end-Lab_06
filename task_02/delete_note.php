<?php
include 'db_config.php';
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];

if ($id) {
    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();


