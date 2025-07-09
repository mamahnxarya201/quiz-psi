<?php
// photo.php: Serves a person's photo from the database for <img src="photo.php?id=...">
require_once __DIR__ . '/../src/Database/ConnectionPDO.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo 'Invalid ID';
    exit;
}

$pdo = \Database\ConnectionPDO::connect();
$stmt = $pdo->prepare('SELECT photo FROM person WHERE id = :id');
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$photo = $stmt->fetchColumn();

if ($photo) {
    // You may want to detect the MIME type dynamically. Default to JPEG.
    header('Content-Type: image/jpeg');
    echo $photo;
    exit;
}
http_response_code(404);
echo 'Photo not found';
