<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];

// Retrieve filters from the GET request
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Set CSV headers for download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="filtered_tasks.csv"');

// Open output stream for CSV
$output = fopen('php://output', 'w');
fputcsv($output, ['Title', 'Description', 'Due Date', 'Category', 'Status']);

// Base SQL query
$sql = "SELECT tasks.title, tasks.description, tasks.due_date, tasks.status, categories.name AS category
        FROM tasks
        LEFT JOIN task_category ON tasks.task_id = task_category.task_id
        LEFT JOIN categories ON task_category.category_id = categories.category_id
        WHERE tasks.user_id = ?";

$params = [$user_id];
$types = "i";

// Add filtering by due date range if provided
if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND tasks.due_date BETWEEN ? AND ?";
    $params[] = $start_date;
    $params[] = $end_date;
    $types .= "ss";
}

// Add filtering by status if provided
if (!empty($status)) {
    $sql .= " AND tasks.status = ?";
    $params[] = $status;
    $types .= "s";
}

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Output each task as a CSV row
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [$row['title'], $row['description'], $row['due_date'], $row['category'], $row['status']]);
}

fclose($output);
?>

