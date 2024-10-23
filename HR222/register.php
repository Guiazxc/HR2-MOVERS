<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'recruitmentdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$registration_success = false; // Variable to track registration success

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($password != $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $sql = "INSERT INTO users (firstname, lastname, username, email, password) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password')";
        
        if ($conn->query($sql) === TRUE) {
            $registration_success = true; // Set success variable
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
</head>
<body>
 
    <div class="main-content">
    
      <div class="register-container">
          <?php if ($registration_success): ?>
              <div class="success-message">
                  <h3>Successfully Registered!</h3>
                  <p>Your account has been created successfully. </p>
                  <p>Click below to log in.</p>
                  <a href="login.php" class="login-btn">LOGIN</a>
              </div>
          <?php else: ?>
              <form class="register-form" action="register.php" method="POST">
                  <h3>Register</h3>
                  <div class="input-group">
                      <label for="firstname">First Name</label>
                      <input type="text" id="firstname" name="firstname" required>
                  </div>
                  <div class="input-group">
                      <label for="lastname">Last Name</label>
                      <input type="text" id="lastname" name="lastname" required>
                  </div>
                  <div class="input-group">
                      <label for="username">Username</label>
                      <input type="text" id="username" name="username" required>
                  </div>
                  <div class="input-group">
                      <label for="email">Email</label>
                      <input type="email" id="email" name="email" required>
                  </div>
                  <div class="input-group">
                      <label for="password">Password</label>
                      <input type="password" id="password" name="password" required>
                  </div>
                  <div class="input-group">
                      <label for="confirm-password">Confirm Password</label>
                      <input type="password" id="confirm-password" name="confirm-password" required>
                  </div>
                  <?php if (isset($error_message)): ?>
                      <div class="error-message"><?php echo $error_message; ?></div>
                  <?php endif; ?>
                  <button type="submit" class="register-btn">Register</button>
                  <div class="extra-links">
                      <a href="login.php">Already have an account? Login</a>
                  </div>
              </form>
          <?php endif; ?>
      </div>
  </div>

</body>
</html>
