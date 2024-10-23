<?php
// Start output buffering and the session
ob_start();
session_start();  // Start the session to handle login

// Database connection
$conn = new mysqli('localhost', 'root', '', 'recruitmentdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch the user
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Start a session and store user information
            $_SESSION['user_logged_in'] = true;  // Set a session variable to track login status
            $_SESSION['username'] = $user['username'];  // Optionally store the username

            // Redirect to dashboard after successful login
            header('Location: dashboard.php');
            exit();
        } else {
            echo "<script>alert('Invalid username or password!');</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password!');</script>";
    }
}

// Check for the registration success message
if (isset($_GET['register']) && $_GET['register'] === 'success') {
    echo "<script>alert('Successfully Registered!');</script>";
}

$conn->close();

// End output buffering and send the output
ob_end_flush();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>

<div class="login-container">
    <img alt="Movers logo with a car icon inside a location pin" src="assets/logo.png"/>

    <form action="login.php" method="POST">
        <input name="username" placeholder="Username or Email" required="" type="text"/>
        <input name="password" placeholder="Password" required="" type="password"/>
        <div style="text-align: left; margin: 10px 0;">
            <input id="remember-me" type="checkbox"/>
            <label for="remember-me">Remember me</label>
        </div>
        <button class="btn" type="submit">LOG IN</button>
    </form>

    <p>
        Don't have an account?
        <a href="register.php">Register</a>
    </p>
</div>

</body>
</html>
