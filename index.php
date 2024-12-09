<?php
include 'header.php';
session_start();
?>

<h2>Welcome to the Task Organizer</h2>

<?php if (isset($_SESSION['user_id'])): ?>
    <p>You are logged in. Go to <a href="tasks.php">Tasks</a> to manage your tasks.</p>
    <p><a href="logout.php">Logout</a></p>
<?php else: ?>
    <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to get started.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
