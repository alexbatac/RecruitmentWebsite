<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $highest_degree = htmlspecialchars(trim($_POST['highest_degree']));
    $field_of_study = htmlspecialchars(trim($_POST['field_of_study']));
    $institution_name = htmlspecialchars(trim($_POST['institution_name']));
    $graduation_year = htmlspecialchars(trim($_POST['graduation_year']));

    if ($highest_degree && $field_of_study && $institution_name && $graduation_year) {
        $_SESSION['highest_degree'] = $highest_degree;
        $_SESSION['field_of_study'] = $field_of_study;
        $_SESSION['institution_name'] = $institution_name;
        $_SESSION['graduation_year'] = $graduation_year;
        header('Location: step3_work_experience.php');
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
    <title>Educational Background</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Step 2: Educational Background</h2>
    
    <!-- Progress Indicator -->
    <ul class="progress-indicator">
        <li class="completed">Step 1: Personal Info</li>
        <li class="active">Step 2: Educational Background</li>
        <li>Step 3: Work Experience</li>
        <li>Step 4: Review and Submit</li>
    </ul>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="step2_education.php" method="POST">
        <label for="highest_degree">Highest Degree Obtained:</label>
        <input type="text" name="highest_degree" value="<?php echo isset($_SESSION['highest_degree']) ? $_SESSION['highest_degree'] : ''; ?>" required><br>

        <label for="field_of_study">Field of Study:</label>
        <input type="text" name="field_of_study" value="<?php echo isset($_SESSION['field_of_study']) ? $_SESSION['field_of_study'] : ''; ?>" required><br>

        <label for="institution_name">Name of Institution:</label>
        <input type="text" name="institution_name" value="<?php echo isset($_SESSION['institution_name']) ? $_SESSION['institution_name'] : ''; ?>" required><br>

        <label for="graduation_year">Year of Graduation:</label>
        <input type="text" name="graduation_year" value="<?php echo isset($_SESSION['graduation_year']) ? $_SESSION['graduation_year'] : ''; ?>" required><br>

        <a href="step1_personal_info.php">Previous</a>
        <button type="submit">Next</button>
    </form>
</body>
</html>
