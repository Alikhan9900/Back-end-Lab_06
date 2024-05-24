<?php
include 'db_config.php';

$title = $_POST['title'];
$content = $_POST['content'];

if ($title && $content) {
    $stmt = $conn->prepare("INSERT INTO notes (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();
    $stmt->close();
}

$conn->close();


