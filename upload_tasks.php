<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['task_csv'])) {
    $file = $_FILES['task_csv']['tmp_name'];
    $user_id = $_SESSION['user_id'];

    if (($handle = fopen($file, "r")) !== FALSE) {
        // Skip the header row
        fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $title = $data[0];
            $description = $data[1];
            $due_date = $data[2];
            $status = $data[3];

            $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $user_id, $title, $description, $due_date, $status);
            $stmt->execute();
        }
        fclose($handle);
        echo "Tasks uploaded successfully!";
    } else {
        echo "Error uploading file.";
    }
}
header('Location: tasks.php');
exit();
?>
