<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone_number = htmlspecialchars(trim($_POST['phone_number']));

    if ($full_name && $email && $phone_number) {
        $_SESSION['full_name'] = $full_name;
        $_SESSION['email'] = $email;
        $_SESSION['phone_number'] = $phone_number;
        header('Location: step2_education.php');
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
    <title>Personal Information</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 style="text-align: center;">Job Application Form</h1>

        <ul class="progress-indicator">
            <li class="active">Step 1: Personal Info</li>
            <li class="incomplete">Step 2: Educational Background</li>
            <li class="incomplete">Step 3: Work Experience</li>
            <li class="incomplete">Step 4: Review and Submit</li>
        </ul>

        <h2>Step 1: Personal Information</h2>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <form action="step1_personal_info.php" method="POST">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" value="<?php echo isset($_SESSION['full_name']) ? $_SESSION['full_name'] : ''; ?>" required><br>

            <label for="email">Email Address:</label>
            <input type="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" value="<?php echo isset($_SESSION['phone_number']) ? $_SESSION['phone_number'] : ''; ?>" required><br>

            <a href="login.php">Previous</a>
            <button type="submit">Next</button>
        </form>
    </div>
</body>
</html>
