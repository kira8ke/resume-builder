<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Resume Builder</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <h1>Resume Builder Dashboard</h1>
        <a href="logout.php" class="logout-button">Logout</a>
    </header>

    <main class="dashboard-container">
        <section class="intro">
        <h2>Welcome, <?php echo isset($_SESSION['fullname']) ? htmlspecialchars($_SESSION['fullname']) : 'Guest'; ?>!</h2>
            <p>Start building your professional resume today.</p>
        </section>

        <!-- Resume Submission Form -->
        <section class="resume-form">
            <h3>Submit Your Resume</h3>
            <form action="submit_resume.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone Number" required>
                <textarea name="experience" placeholder="Experience" required></textarea>
                <textarea name="skills" placeholder="Skills" required></textarea>

                <!-- File Upload for Resume -->
                <label for="resume">Upload Your Resume (PDF/DOCX):</label>
                <input type="file" name="resume" accept=".pdf,.docx" required>

                <button type="submit">Submit Resume</button>
            </form>
        </section>

        <!-- Resume Preview Section -->
        <section class="resume-preview">
            <h3>Your Resume Preview</h3>
            <p>Once you submit your details, your resume will be auto-generated here.</p>
        </section>
    </main>

</body>
</html>
