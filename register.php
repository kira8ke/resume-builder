<?php
session_start();
include 'db_config.php'; // Ensure this file is correct

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($fullname) || empty($email) || empty($password)) {
        die("⚠️ Error: All fields are required!");
    }

    try {
        // Log that the script reached this point
        error_log("🔵 Checking if email already exists: $email");

        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            die("⚠️ Error: Email already registered!");
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        error_log("🔵 Password hashed for user: $fullname");

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)");
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        if ($stmt->execute()) {
            error_log("✅ User $fullname registered successfully.");
            echo "✅ Registration successful! Redirecting to login...";
            header("Refresh: 2; URL=login.php"); // Redirect after 2 seconds
            exit();
        } else {
            die("❌ Error: Registration failed! Check database permissions.");
        }
    } catch (PDOException $e) {
        die("❌ Database Error: " . $e->getMessage());
    }
}
?>
