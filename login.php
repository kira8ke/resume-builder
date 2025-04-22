<?php
session_start();
include 'db_config.php'; // Uses $conn, not $pdo

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "⚠️ All fields are required!";
        exit();
    }

    try {
        // Use $conn instead of $pdo
        $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "❌ No user found with this email.";
            exit();
        }

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "❌ Invalid password!";
            exit();
        }
    } catch (PDOException $e) {
        echo "❌ Database Error: " . $e->getMessage();
    }
}
?>
