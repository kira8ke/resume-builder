<?php
session_start();
require 'db_config.php'; // Uses $conn now

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Sanitize input
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $experience = htmlspecialchars(trim($_POST['experience']));
    $skills = htmlspecialchars(trim($_POST['skills']));

    $resume_file = null;

    // Handle resume file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $file_type = mime_content_type($_FILES['resume']['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            $upload_dir = "uploads/";
            $unique_name = uniqid() . '_' . basename($_FILES['resume']['name']);
            $target_path = $upload_dir . $unique_name;

            if (move_uploaded_file($_FILES['resume']['tmp_name'], $target_path)) {
                $resume_file = $target_path;
            } else {
                die("Error uploading the resume file.");
            }
        } else {
            die("Invalid file type. Please upload a PDF or Word document.");
        }
    }

    // Insert into database
    $sql = "INSERT INTO resumes (user_id, full_name, email, phone, experience, skills, resume_file) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute([$user_id, $full_name, $email, $phone, $experience, $skills, $resume_file]);

    if ($success) {
        header("Location: dashboard.php?success=Resume submitted!");
        exit();
    } else {
        echo "Error saving resume.";
    }
}
?>
