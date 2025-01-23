<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Fetch the file path from the database
    $stmt = $conn->prepare("SELECT image_path FROM photos WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();

    if ($imagePath && file_exists($imagePath)) {
        unlink($imagePath); // Delete the file from the server

        // Remove metadata from the database
        $stmt = $conn->prepare("DELETE FROM photos WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    header('Location: index.php');
    exit;
}
?>
