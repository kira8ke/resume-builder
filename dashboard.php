<?php
session_start();

// Redirect to login if user is not authenticated
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2 class="logo">Resume Builder</h2>
        <a href="logout.php" class="logout-button">Logout</a>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-container">
        <header class="intro">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'Guest'); ?>!</h1>
            <p>Start building your professional resume today.</p>
        </header>

        <!-- Resume Submission Form -->
        <section class="resume-form slide-in-left">
            <h3>Submit Your Resume</h3>
            <form action="submit_resume.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone Number" required>
                <textarea name="experience" placeholder="Experience" required></textarea>
                <textarea name="skills" placeholder="Skills" required></textarea>

                <label for="resume">Upload Your Resume (PDF/DOCX):</label>
                <input type="file" name="resume" id="resume" accept=".pdf,.docx" required>

                <button type="submit">Submit Resume</button>
            </form>
        </section>

        <!-- Resume Preview -->
        <section class="resume-preview slide-in-right">
            <h3>Your Resume Preview</h3>
            <p>Once you submit your details, your resume will be auto-generated here.</p>
        </section>
    </main>

    <script src="script.js"></script>

</body>
</html>
