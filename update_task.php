<?php
include 'db.php';
session_start();

$user_id = $_SESSION['user_id'];

// Handle Add Task
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("isss", $user_id, $title, $description, $due_date);
    $stmt->execute();
}

// Handle Sorting and Fetch Tasks
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc'; // Default to 'asc'
$order = ($sort_order === 'desc') ? 'DESC' : 'ASC';

// Fetch tasks with sorting by due date
$sql = "SELECT * FROM tasks WHERE user_id = '$user_id' ORDER BY due_date $order";
$result = $conn->query($sql);

// Output tasks as JSON
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
?>
