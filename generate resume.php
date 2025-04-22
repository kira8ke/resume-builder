<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the latest resume
$stmt = $conn->prepare("SELECT * FROM resumes WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$user_id]);
$resume = $stmt->fetch();

if (!$resume) {
    die("No resume found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Generated Resume</title>
    <link rel="stylesheet" href="../css/resume.css">
</head>
<body>
    <div class="resume-container">
        <h1><?php echo htmlspecialchars($resume['full_name']); ?></h1>
        <p>Email: <?php echo htmlspecialchars($resume['email']); ?></p>
        <p>Phone: <?php echo htmlspecialchars($resume['phone']); ?></p>

        <h2>Experience</h2>
        <p><?php echo nl2br(htmlspecialchars($resume['experience'])); ?></p>

        <h2>Skills</h2>
        <p><?php echo nl2br(htmlspecialchars($resume['skills'])); ?></p>

        <?php if (!empty($resume['resume_file'])): ?>
            <p><a href="<?php echo htmlspecialchars($resume['resume_file']); ?>" target="_blank">Download Uploaded Resume</a></p>
        <?php endif; ?>

        <button onclick="window.print()">Print Resume</button>
    </div>
</body>
</html>
