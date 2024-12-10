<?php 
include 'db.php';
include 'header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember_me']);

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];

        // Set a persistent login cookie if "Remember Me" is checked
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            setcookie('remember_me', $token, time() + (86400 * 30), "/", "", false, true); // 30-day expiration, HttpOnly

            // Store the token in the database
            $stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE user_id = ?");
            $stmt->bind_param("si", $token, $user['user_id']);
            $stmt->execute();
        }

        header('Location: index.php');
        exit();
    } else {
        echo "<p style='color:red; text-align:center;'>Invalid credentials!</p>";
    }
}
?>

<div class="content">
    <div class="login-box">
        <h2>Login</h2>
        <form method="POST" onsubmit="return validatePassword()">
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-input" type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-input" type="password" name="password" id="password" required>
                <small>Password must be at least 8 characters long, with at least one uppercase letter, one digit, and one symbol.</small>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember_me"> Remember Me
                </label>
            </div>
            <input class="btn-login" type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php" class="btn-register">Register</a></p>
    </div>
</div>

<script>
function validatePassword() {
    const password = document.getElementById('password').value;
    const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (!passwordPattern.test(password)) {
        alert('Password must be at least 8 characters long, with at least one uppercase letter, one digit, and one symbol.');
        return false;
    }
    return true;
}
</script>

<?php include 'footer.php'; ?>



