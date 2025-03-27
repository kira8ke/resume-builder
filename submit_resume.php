<?php
session_start();
require 'db_config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $experience = $_POST['experience'];
    $skills = $_POST['skills'];

    // File Upload Handling
    $resume_file = null;
    if (!empty($_FILES['resume']['name'])) {
        $target_dir = "../uploads/";
        $resume_file = $target_dir . basename($_FILES["resume"]["name"]);
        move_uploaded_file($_FILES["resume"]["tmp_name"], $resume_file);
    }

    // Insert data into the database
    $sql = "INSERT INTO resumes (user_id, full_name, email, phone, experience, skills, resume_file)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$user_id, $full_name, $email, $phone, $experience, $skills, $resume_file])) {
        header("Location: dashboard.php?success=Resume submitted!");
        exit();
    } else {
        echo "Error submitting resume.";
    }
}
?>
