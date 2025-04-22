<?php
session_start();
include 'db_config.php'; // This now uses $conn

// Enable error reporting (for development only)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($fullname) || empty($email) || empty($password)) {
        die("⚠️ Error: All fields are required!");
    }

    try {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            die("⚠️ Error: Email already registered!");
        }

        // Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)");
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "✅ Registration successful! Redirecting to login...";
            header("Refresh: 2; URL=login.php");
            exit();
        } else {
            die("❌ Error: Registration failed! Please try again.");
        }

    } catch (PDOException $e) {
        die("❌ Database Error: " . $e->getMessage());
    }
}
?>
