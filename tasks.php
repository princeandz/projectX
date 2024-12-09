<?php
include 'db.php';
include 'header.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<h2>Your Tasks</h2>

<form id="task-form">
    Title: <input type="text" id="title" required><br>
    Description: <input type="text" id="description" required><br>
    Due Date: <input type="date" id="due_date" required><br>
    <button type="submit">Add Task</button>
</form>

<table border="1" id="task-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script src="scripts/main.js"></script>

<?php include 'footer.php'; ?>
