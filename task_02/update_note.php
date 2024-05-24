<?php
include 'db_config.php';
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$title = $data['title'];
$content = $data['content'];

if ($id && $title && $content) {
    $stmt = $conn->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>

