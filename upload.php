<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $title = $_POST['title'];
    $image = $_FILES['image'];

    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (!in_array($image['type'], $allowedTypes)) {
        die('Invalid file type. Only JPG, PNG, webp and GIF are allowed.');
    }

    // Move uploaded file to the uploads directory
    $uploadsDir = 'uploads/';
    $filePath = $uploadsDir . basename($image['name']);

    if (move_uploaded_file($image['tmp_name'], $filePath)) {
        // Save metadata to the database
        $stmt = $conn->prepare("INSERT INTO photos (title, image_path) VALUES (?, ?)");
        $stmt->bind_param('ss', $title, $filePath);
        $stmt->execute();
        $stmt->close();

        header('Location: index.php');
        exit;
    } else {
        die('File upload failed.');
    }
}
?>
