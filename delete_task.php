<?php
include 'db.php';
session_start();

$task_id = $_POST['task_id'];
$stmt = $conn->prepare("DELETE FROM tasks WHERE task_id = ?");
$stmt->bind_param("i", $task_id);
$stmt->execute();
?>
