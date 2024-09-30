<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_title = htmlspecialchars(trim($_POST['job_title']));
    $company_name = htmlspecialchars(trim($_POST['company_name']));
    $years_experience = htmlspecialchars(trim($_POST['years_experience']));
    $responsibilities = htmlspecialchars(trim($_POST['responsibilities']));

    if ($job_title && $company_name && $years_experience && $responsibilities) {
        $_SESSION['job_title'] = $job_title;
        $_SESSION['company_name'] = $company_name;
        $_SESSION['years_experience'] = $years_experience;
        $_SESSION['responsibilities'] = $responsibilities;
        header('Location: review.php');
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Experience</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Step 3: Work Experience</h2>
    
    <!-- Progress Indicator -->
    <ul class="progress-indicator">
        <li class="completed">Step 1: Personal Info</li>
        <li class="completed">Step 2: Educational Background</li>
        <li class="active">Step 3: Work Experience</li>
        <li>Step 4: Review and Submit</li>
    </ul>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="step3_work_experience.php" method="POST">
        <label for="job_title">Previous Job Title:</label>
        <input type="text" name="job_title" value="<?php echo isset($_SESSION['job_title']) ? $_SESSION['job_title'] : ''; ?>" required><br>

        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" value="<?php echo isset($_SESSION['company_name']) ? $_SESSION['company_name'] : ''; ?>" required><br>

        <label for="years_experience">Years of Experience:</label>
        <input type="text" name="years_experience" value="<?php echo isset($_SESSION['years_experience']) ? $_SESSION['years_experience'] : ''; ?>" required><br>

        <label for="responsibilities">Key Responsibilities:</label>
        <textarea name="responsibilities" required><?php echo isset($_SESSION['responsibilities']) ? $_SESSION['responsibilities'] : ''; ?></textarea><br>

        <a href="step2_education.php">Previous</a>
        <button type="submit">Next</button>
    </form>
</body>
</html>
