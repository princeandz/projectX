<?php
include 'header.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Organizer - Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the external CSS -->
</head>
<body>

    <div class="container">
        <div class="login-box">
            <h2>Welcome to the Task Organizer</h2>

            <?php if (isset($_SESSION['user_id'])): ?>
                <p>You are logged in. Go to <a href="tasks.php">Tasks</a> to manage your tasks.</p>
                <p><a href="logout.php" class="btn-logout">Logout</a></p>
            <?php else: ?>
                <p><a href="login.php" class="btn-login">Login</a> or <a href="register.php" class="btn-register">Register</a> to get started.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

<?php include 'footer.php'; ?>
