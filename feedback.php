<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Feedback - Task Organizer</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <!-- Feedback Form Section -->
    <section id="feedback-form-container">
        <h2>We Value Your Feedback</h2>
        <form action="https://formspree.io/f/xkgnabza" method="POST">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required><br>

            <p>Your Feedback:</p>
            <textarea id="message" name="message" required></textarea><br>
            <button type="submit">Submit Feedback</button>
            <p>Or email us at andrej.ignjatovic@knf.stud.vu.lt</p>
        </form>
    </section>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
</body>
</html>
