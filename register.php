<?php
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
    echo "<p style='color: green; text-align: center;'>Registration successful! You can <a href='login.php'>login</a> now.</p>";
}
?>

<div class="register-box">
    <h2>Register</h2>
    <form method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input class="form-input" type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-input" type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-input" type="password" name="password" id="password" required>
        </div>
        <input class="btn-register" type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php" class="btn-register">Login</a></p>
</div>

<?php include 'footer.php'; ?>
