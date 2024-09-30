<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Load the users.json file
    $file = 'users.json';
    if (file_exists($file)) {
        $users = json_decode(file_get_contents($file), true);

        // Find the user
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Start session
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $user['email']; // Store email in session

                    // Handle Remember Me checkbox
                    if (isset($_POST['remember_me'])) {
                        setcookie('username', $username, time() + (7 * 24 * 60 * 60), "/"); // 7 days
                    } else {
                        // If not checked, ensure the cookie is removed
                        if (isset($_COOKIE['username'])) {
                            setcookie('username', '', time() - 3600, "/"); // Remove cookie
                        }
                    }

                    // Redirect to the job application form
                    header('Location: step1_personal_info.php');
                    exit;
                } else {
                    echo "<h2 style='color:red;'>Incorrect password.</h2>";
                    echo "<h3>Go back to <a href='login.php'>Login Page</a>.</h3>";
                    exit;
                }
            }
        }

        echo "<h2 style='color:red;'>User Not Found.</h2>";
        
    } else {
        echo "<h2 style='color:red;'>No registered users found.</h2>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="remember_me">
            <input type="checkbox" name="remember_me"> Remember Me
        </label><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
