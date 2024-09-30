<?php
session_start();

// Check if all session variables are set
if (!isset($_SESSION['full_name'], $_SESSION['email'], $_SESSION['phone_number'], 
          $_SESSION['highest_degree'], $_SESSION['field_of_study'], $_SESSION['institution_name'], 
          $_SESSION['graduation_year'], $_SESSION['job_title'], $_SESSION['company_name'], 
          $_SESSION['years_experience'], $_SESSION['responsibilities'])) {
    header('Location: step1_personal_info.php');
    exit;
}


// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gather the application data from the session
    $application = [
        'full_name' => $_SESSION['full_name'],
        'email' => $_SESSION['email'],
        'phone_number' => $_SESSION['phone_number'],
        'highest_degree' => $_SESSION['highest_degree'],
        'field_of_study' => $_SESSION['field_of_study'],
        'institution_name' => $_SESSION['institution_name'],
        'graduation_year' => $_SESSION['graduation_year'],
        'job_title' => $_SESSION['job_title'],
        'company_name' => $_SESSION['company_name'],
        'years_experience' => $_SESSION['years_experience'],
        'responsibilities' => $_SESSION['responsibilities']
    ];

    // Load or create the applications.json file
    $file = 'applications.json';
    $applications = [];

    if (file_exists($file)) {
        $applications = json_decode(file_get_contents($file), true);
    }

    // Add the new application
    $applications[] = $application;
    file_put_contents($file, json_encode($applications));

    // Email setup using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                          
        $mail->Host = 'smtp.gmail.com';                
        $mail->SMTPAuth = true;                                   
        $mail->Username = 'batacalex1989@gmail.com';   //not real email
        $mail->Password = 'password'; //not the real password
        $mail->SMTPSecure = 'tls';     
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('batalex1989@gmail.com', 'Job Application System');
        $mail->addAddress($application['email']);     // Add the applicant's email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Application Submitted Successfully';
        
        // Email body with application details
        $mailContent = "
        <h3>Dear {$application['full_name']},</h3>
        <p>Your job application has been successfully submitted. Below are the details:</p>
        <h4>Personal Information:</h4>
        <ul>
            <li><strong>Full Name:</strong> {$application['full_name']}</li>
            <li><strong>Email:</strong> {$application['email']}</li>
            <li><strong>Phone Number:</strong> {$application['phone_number']}</li>
        </ul>
        <h4>Educational Background:</h4>
        <ul>
            <li><strong>Highest Degree:</strong> {$application['highest_degree']}</li>
            <li><strong>Field of Study:</strong> {$application['field_of_study']}</li>
            <li><strong>Institution Name:</strong> {$application['institution_name']}</li>
            <li><strong>Graduation Year:</strong> {$application['graduation_year']}</li>
        </ul>
        <h4>Work Experience:</h4>
        <ul>
            <li><strong>Job Title:</strong> {$application['job_title']}</li>
            <li><strong>Company Name:</strong> {$application['company_name']}</li>
            <li><strong>Years of Experience:</strong> {$application['years_experience']}</li>
            <li><strong>Responsibilities:</strong> {$application['responsibilities']}</li>
        </ul>
        <p>Thank you for your application!</p>";

        $mail->Body = $mailContent;

        // Send email
        $mail->send();
        echo "<h2>Application submitted successfully! A confirmation email with details has been sent.</h2>";
        echo "<h3>Logout and Go Back to <a href='logout.php'>Login Page</a>.</h3>";
    } catch (Exception $e) {
        echo "Application submitted successfully! However, the confirmation email could not be sent. Error: {$mail->ErrorInfo}";
        echo "<h3>Logout and Go Back to <a href='logout.php'>Login Page</a>.</h3>";
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Your Application</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Review Your Application</h2>
    
    <!-- Progress Indicator -->
    <ul class="progress-indicator">
        <li class="completed">Step 1: Personal Info</li>
        <li class="completed">Step 2: Educational Background</li>
        <li class="completed">Step 3: Work Experience</li>
        <li class="active">Step 4: Review and Submit</li>
    </ul>

    <form action="review.php" method="POST">
        <h3>PERSONAL INFORMATION</h3>
        <p><strong>Full Name:</strong> <?php echo $_SESSION['full_name']; ?></p>
        <p><strong>Email Address:</strong> <?php echo $_SESSION['email']; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $_SESSION['phone_number']; ?></p>

        <h3>EDUCATIONAL BACKGROUND</h3>
        <p><strong>Highest Degree:</strong> <?php echo $_SESSION['highest_degree']; ?></p>
        <p><strong>Field of Study:</strong> <?php echo $_SESSION['field_of_study']; ?></p>
        <p><strong>Institution Name:</strong> <?php echo $_SESSION['institution_name']; ?></p>
        <p><strong>Year of Graduation:</strong> <?php echo $_SESSION['graduation_year']; ?></p>

        <h3>WORK EXPERIENCE</h3>
        <p><strong>Previous Job Title:</strong> <?php echo $_SESSION['job_title']; ?></p>
        <p><strong>Company Name:</strong> <?php echo $_SESSION['company_name']; ?></p>
        <p><strong>Years of Experience:</strong> <?php echo $_SESSION['years_experience']; ?></p>
        <p><strong>Key Responsibilities:</strong> <?php echo $_SESSION['responsibilities']; ?></p>

        <button type="submit">Submit Application</button>
        <a href="step3_work_experience.php">Previous</a>
    </form>
</body>
</html>
