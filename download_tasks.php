<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch tasks from the database
$result = $conn->query("SELECT title, description, due_date, status FROM tasks WHERE user_id = '$user_id'");

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="tasks.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Title', 'Description', 'Due Date', 'Status']);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
