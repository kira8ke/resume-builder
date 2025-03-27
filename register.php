<?php
require 'db_config.php'; // Ensure this file contains a working PDO connection
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input values
    $fullname = isset($_POST["fullname"]) ? trim($_POST["fullname"]) : '';
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';

    // Validate input fields
    if (empty($fullname) || empty($email) || empty($password)) {
        echo "<p class='error'>All fields are required.</p>";
    } else {
        // Check if the email is already registered
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $emailExists = $stmt->fetchColumn();

            if ($emailExists) {
                echo "<p class='error'>Email already exists. Try logging in.</p>";
            } else {
                // Hash the password for security
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert user into the database
                $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)");
                $stmt->execute([
                    ':fullname' => $fullname,
                    ':email' => $email,
                    ':password' => $hashed_password
                ]);

                echo "<p class='success'>Registration successful! Redirecting to login...</p>";
                header("refresh:2;url=login.php"); // Redirect after 2 seconds
                exit();
            }
        } catch (PDOException $e) {
            die("Error inserting user: " . $e->getMessage());
        }
    }
}
?>
