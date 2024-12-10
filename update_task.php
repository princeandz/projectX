<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];

// Handle Add Task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("isss", $user_id, $title, $description, $due_date);
    $stmt->execute();
    exit();
}

// Handle Mark as Done
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_done_id'])) {
    $task_id = $_POST['mark_done_id'];
    $stmt = $conn->prepare("UPDATE tasks SET status = 'Done' WHERE task_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();
    exit();
}

// Handle Sorting
$sort_order = isset($_GET['sort_order']) && $_GET['sort_order'] === 'desc' ? 'DESC' : 'ASC';

// Handle Search Parameters
$search_title = isset($_GET['search_title']) ? '%' . $_GET['search_title'] . '%' : '%';
$search_due_date = isset($_GET['search_due_date']) && $_GET['search_due_date'] !== '' ? $_GET['search_due_date'] : null;
$search_status = isset($_GET['search_status']) && $_GET['search_status'] !== '' ? $_GET['search_status'] : '%';

// Base SQL Query
$sql = "SELECT * FROM tasks WHERE user_id = ? AND title LIKE ? AND status LIKE ?";
$params = [$user_id, $search_title, $search_status];
$types = "iss";

// Apply Due Date Filter if Provided
if ($search_due_date) {
    $sql .= " AND due_date = ?";
    $params[] = $search_due_date;
    $types .= "s";
}

// Apply Sorting
$sql .= " ORDER BY due_date $sort_order";

// Prepare and Execute the Query
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Output tasks as JSON
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
?>




