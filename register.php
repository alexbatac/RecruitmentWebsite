<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    // Input validation
    if (!$email) {
        echo "Invalid email.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Store the user data in users.json
    $user_data = [
        'username' => $username,
        'email' => $email,
        'password' => $hashed_password
    ];

    $file = 'users.json';
    if (!file_exists($file)) {
        file_put_contents($file, json_encode([])); // Create an empty array if file doesn't exist
    }

    // Read existing users
    $users = json_decode(file_get_contents($file), true);

    // Check if the username already exists
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            echo "<h2 style='color:red;'>Username already exists. Please choose a different username.</h2>";
            echo "<p>Go back to <a href='UserReg.html'>User Registration</a>.</p>";
            exit;
        }
    }

    // Add new user
    $users[] = $user_data;

    // Save back to the file
    file_put_contents($file, json_encode($users));

    // Store email in session
    $_SESSION['email'] = $email; // Store the email in the session

    echo "<h2>Registration Successful!</h2>";
    echo "<p>You can now <a href='login.php'>log in</a>.</p>";
}
?>
