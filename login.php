<?php
include 'dashboard.php'; // Ensure this file exists and is correct

session_start(); // Start session after including database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['fullname'] = $row['fullname'];
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "No user found!";
        }

        $stmt->close();
    } else {
        echo "Please enter email and password!";
    }
}

$conn->close();
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'dashboard.php'; // Make sure this file exists and is correctly included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    try {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid credentials!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
