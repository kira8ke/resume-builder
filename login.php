<?php
session_start();
include 'db_config.php'; // Ensure this file has a working PDO connection

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    try {
        // Fetch user details based on email
        $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debugging: Check if user exists
        if (!$user) {
            echo "No user found with email: " . htmlspecialchars($email) . "<br>";
            exit();
        }

        // Debugging: Show stored hashed password and entered password
        echo "Stored Hashed Password: " . $user['password'] . "<br>";
        echo "Entered Password: " . $password . "<br>";

        // Check if the password matches
        if (password_verify($password, $user['password'])) {
            echo "✅ Password Matched! Redirecting to dashboard...<br>";

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "❌ Invalid password!<br>";
            exit();
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>
