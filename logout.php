<?php
include 'db.php';

// Check if a session is already active before starting one
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Clear the remember_token in the database
    $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

// Destroy the session
session_destroy();

// Clear the remember_me cookie
setcookie('remember_me', '', time() - 3600, "/");

header('Location: index.php');
exit();
?>



