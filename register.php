<?php
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Password validation pattern
    $password_pattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    if (!preg_match($password_pattern, $password)) {
        echo "<p style='color: red; text-align: center;'>Password must be at least 8 characters long, with at least one uppercase letter, one digit, and one symbol.</p>";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<p style='color: green; text-align: center;'>Registration successful! You can <a href='login.php'>login</a> now.</p>";
        } else {
            echo "<p style='color: red; text-align: center;'>Error: " . $stmt->error . "</p>";
        }
    }
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
        <div class="form-group">
            <small>Password must be at least 8 characters long, with at least one uppercase letter, one digit, and one symbol.</small>
        </div>
        <input class="btn-register" type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php" class="btn-register">Login</a></p>
</div>

<?php include 'footer.php'; ?>

