<?php
include 'db.php';
session_start();

$user_id = $_SESSION['user_id'];

// Add Task
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("isss", $user_id, $title, $description, $due_date);
    $stmt->execute();
}

// Read Tasks
$result = $conn->query("SELECT * FROM tasks WHERE user_id = '$user_id'");
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
?>
