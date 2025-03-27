<?php
require 'db_config.php'; // Ensure this file contains a valid PDO connection
session_start();

// Enable error reporting to see any hidden errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and trim form inputs
    $fullname = isset($_POST["fullname"]) ? trim($_POST["fullname"]) : '';
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';

    // Check if any field is empty
    if (empty($fullname) || empty($email) || empty($password)) {
        die("<p style='color:red;'>All fields are required. Please go back and fill in all details.</p>");
    }

    try {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            die("<p style='color:red;'>Email already registered. Try logging in.</p>");
        }

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)");
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect to login page after successful registration
        echo "<p style='color:green;'>Registration successful! Redirecting to login...</p>";
        header("refresh:2;url=login.php"); // Redirect after 2 seconds
        exit();
    } catch (PDOException $e) {
        die("<p style='color:red;'>Database error: " . $e->getMessage() . "</p>");
    }
} else {
    die("<p style='color:red;'>Invalid request method. Please submit the form properly.</p>");
}
?>
