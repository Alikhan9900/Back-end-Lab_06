<?php
include 'db_config.php';

$result = $conn->query("SELECT id, title, content FROM notes");
$notes = [];

while ($row = $result->fetch_assoc()) {
    $notes[] = $row;
}

echo json_encode($notes);

$conn->close();
?>

