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
    $sql = "SELECT * FROM applicant_users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Start a session and store user information
            $_SESSION['user_logged_in'] = true;  // Set a session variable to track login status
            $_SESSION['username'] = $user['username'];  // Optionally store the username

            // Redirect to dashboard after successful login
            header('Location: index.php');
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
    
</head>
<body>

<style>
          body {
            background-color: #d0e7ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container img {
            width: 150px;
            margin-bottom: 20px;
        }
        .login-container h1 {
            font-size: 36px;
            color: #0056d2;
            margin-bottom: 20px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container input[type="checkbox"] {
            margin-right: 10px;
        }
        .login-container label {
            font-size: 14px;
            color: #333;
        }
        .login-container a {
            color: #0056d2;
            text-decoration: none;
            font-size: 14px;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        .login-container .btn {
            background-color: #0056d2;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .login-container .btn:hover {
            background-color: #0041a8;
        }


</style>

<div class="login-container">
    <img src="../assets/logo.png" alt="logo" />

    <form action="index-login.php" method="POST">
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
        <a href="index-register.php">Register</a>
    </p>
</div>

</body>
</html>
