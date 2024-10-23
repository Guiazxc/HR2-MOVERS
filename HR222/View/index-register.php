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
        $sql = "INSERT INTO applicant_users (firstname, lastname, username, email, password) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password')";
        
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
</head>
<body>
  <style>
    body {
  background-color: #007aff26; /* Light blue background */
  margin: 0; 
  display: flex;
  flex-direction: column;
  align-items: center; 
  justify-content: center;
  height: 80vh; 
  padding-top: 60px; 
}

.register-container {
  display: flex; 
  flex-direction: column; 
  align-items: center; 
  width: 360px; /* Fixed width for the form */
  background-color: #fff; /* White background for the form */
  padding: 10px;
  padding-top: 0px;
  border-radius: 10px; /* Rounded corners */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
  margin: 0px 0; /* Reduced top margin to move it up */
  position: relative; /* Allows for further positioning adjustments if needed */
  top: 30px; /* Move the container further up */
}


.register-container .success-message {
  text-align: center; /* Center text for success message */
  margin-bottom: 20px; /* Spacing below the message */
  font-family: Arial; /* Font for message */
  color: #28a745; /* Green color for success message */
}

.register-container .error-message {
  color: #dc3545; /* Red color for error message */
  margin-bottom: 15px; /* Spacing below error message */
}

.register-form h3 {
  text-align: center; /* Centered heading */
  margin-bottom: 20px; /* Spacing below heading */
  font-family: Arial; /* Font for heading */
}

.input-group {
  margin-bottom: 10px; /* Spacing between input groups */
  width: 280px; 
}

.input-group label {
  display: block; /* Block display for label */
  margin-bottom: 5px; /* Spacing below label */
  font-family: Arial; /* Font for labels */
  font-weight: bold; /* Bold labels */
}

.input-group input {
  width: 280px; /* Full width for inputs */
  padding: 10px; /* Padding inside inputs */
  border: 1px solid #ccc; /* Light grey border */
  border-radius: 5px; /* Rounded corners for inputs */
  font-size: 16px; /* Font size for input text */
}

.register-btn {
  width: 300px; /* Full width for button */
  padding: 10px; /* Padding inside button */
  background-color: #007bff; /* Primary button color */
  color: white; /* White text color */
  border: none; /* No border */
  border-radius: 5px; /* Rounded corners */
  font-size: 16px; /* Font size for button text */
  cursor: pointer; /* Pointer cursor on hover */
  transition: background-color 0.3s ease; /* Transition effect for background */
}

.register-btn:hover {
  background-color: #0056b3; /* Darker blue on hover */
}

.extra-links {
  display: flex; /* Flex container for links */
  justify-content: center; /* Centered links */
  margin-top: 10px; /* Spacing above links */
}

.extra-links a {
  text-decoration: none; /* No underline */
  color: #007bff; /* Link color */
  font-size: 14px; /* Font size for links */
}

.extra-links a:hover {
  text-decoration: underline; /* Underline on hover */
}

.login-btn {
  display: inline-block; /* Inline block for button */
  padding: 10px 15px; /* Padding for button */
  background-color: #007bff; /* Button color */
  color: white; /* White text color */
  border-radius: 5px; /* Rounded corners */
  text-align: center; /* Center text in button */
  margin-top: 10px; /* Spacing above button */
  text-decoration: none; /* No underline */
  transition: background-color 0.3s ease; /* Transition effect for button */
}

.login-btn:hover {
  background-color: #0056b3; /* Darker blue on hover */
}
  </style>
 
    <div class="main-content">
    
      <div class="register-container">
          <?php if ($registration_success): ?>
              <div class="success-message">
                  <h3>Successfully Registered!</h3>
                  <p>Your account has been created successfully. </p>
                  <p>Click below to log in.</p>
                  <a href="index-login.php" class="login-btn">LOGIN</a>
              </div>
          <?php else: ?>
              <form class="register-form" action="index-register.php" method="POST">
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
                      <a href="index-login.php">Already have an account? Login</a>
                  </div>
              </form>
          <?php endif; ?>
      </div>
  </div>

</body>
</html>
