<?php
session_start();
require_once("connection.php");

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 

if (isset($_GET['id']) && isset($_SESSION['id'])) {
    $imageId = $_GET['id'];
    $userId = $_SESSION['id'];

    // Fetch the image from the database
    $stmt = $conn->prepare("SELECT data FROM images WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $imageId, $userId);
    $stmt->execute();
    $stmt->bind_result($imageData);

    if ($stmt->fetch()) {
        // Serve the image
        header("Content-Type: image/jpeg"); // Adjust if necessary
        echo $imageData;
    } else {
        // Redirect to home if no image is found
        header("Location: home.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect to home for invalid requests
    header("Location: home.php");
    exit();
}
?>