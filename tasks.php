<?php
include 'db.php';
include 'header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!-- Task Form Box -->
<div id="task-form-container">
    <form id="task-form">
        <h2>Add a Task</h2>
        <label for="title">Title</label>
        <input type="text" id="title" required><br>
        <label for="description">Description</label>
        <input type="text" id="description" required><br>
        <label for="due_date">Due Date</label>
        <input type="date" id="due_date" required><br>
        <button type="submit">Add Task</button>
    </form>
</div>

<h2>Your Tasks</h2>

<!-- Task Table -->
<table id="task-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th id="due-date-header" style="cursor: pointer;">Due Date</th> <!-- Make this clickable -->
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Rows will be dynamically added here -->
    </tbody>
</table>

<!-- Buttons for CSV Import and Export -->
<h3>Filter Tasks for CSV Download</h3>
<form action="download_tasks.php" method="GET" style="margin-bottom: 20px;">
    <div style="margin-bottom: 10px;">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
        
        <label for="end_date" style="margin-left: 20px;">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>
    </div>

    <div style="margin-bottom: 10px;">
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="">All</option>
            <option value="Pending">Pending</option>
            <option value="Done">Done</option>
        </select>
    </div>

    <div style="margin-bottom: 10px;">
        <button type="submit" class="small-button">
            Download Tasks as CSV
        </button>
    </div>
</form>


<form action="upload_tasks.php" method="POST" enctype="multipart/form-data" class="upload-form">
    <button type="submit" class="small-button">
        Upload Tasks from CSV
    </button>
    <input type="file" name="task_csv" accept=".csv" required>
</form>

<script src="scripts/main.js"></script>

<?php include 'footer.php'; ?>




