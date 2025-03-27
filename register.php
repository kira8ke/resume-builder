<?php
require 'db_config.php'; // Ensure you have a database connection file

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use isset() to avoid "undefined array key" errors
    $fullname = isset($_POST["fullname"]) ? trim($_POST["fullname"]) : null;
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
    $password = isset($_POST["password"]) ? $_POST["password"] : null;

    // Validate that all fields are provided
    if (!$fullname || !$email || !$password) {
        die("All fields are required.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)");
        $stmt->execute([
            ':fullname' => $fullname,
            ':email' => $email,
            ':password' => $hashed_password
        ]);

        echo "Registration successful! <a href='login.php'>Login Here</a>";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

