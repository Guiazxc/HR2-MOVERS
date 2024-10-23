<?php
session_start();  // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // Redirect the user to the login page if not logged in
    header('Location: index-login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Application Status</title> 
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="header">
    <span>Application Status</span>
    <img src="../assets/logo.png" alt="Logo">
</div>

<div class="container">
    <div class="photo">
        <img src="../assets/logo.png">
    </div>
    
    <div class="personal-detail">
      <!--dito nakalagay yung mga input nila na details sa register--> 
            <i class="fas fa-tachometer-alt icon"></i> PERSONAL DETAILS 
        </a>
    </div>

    <div class="Logout">
        <a href="index-logout.php" class="logoutbtn">
            <i class="fas fa-sign-out-alt icon"></i> LOG OUT
        </a>
    </div>
</div>


<div class="status-container">
    <div class="dash-item">Information Status</div>
    <div class="dash-item">Interview Status</div>
    <div class="dash-item">Application Status</div>
    <div class="dash-item">Onboarding Status</div>
    <div class="dash-item">Training Schedule</div>
</div>

<style>
  body{
    background-color: #007bff11;
    font-family: Arial, sans-serif;
   
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }

  .header{
        background-color: #fcfdff;
        position: fixed;
        top: 0px;
        left: 232px;
        right: 0px;
        height: 30px;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 20px;
        display: flex;
        align-items: left;
        justify-content: space-between;
        color: #0046fa;
        font-family: system-ui;
        font-weight: bold;
        font-size: 19px;
        text-align: left;
      }
      .header img {
        height: 30px; 
        width: auto;
        margin-right: 10px;
      }
      /*Side Nav*/
      .container {
        width: 230px;
        height: 100vh;
        background-color: #fcfdff;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 0px;
        box-sizing: border-box;
        margin-left: 0px;
        overflow-y: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .container::-webkit-scrollbar {
        display: none;
    }
    
    .photo img{
        margin-top: 40px;
        height: 70px;
        width: auto;
        align-items: center;
        margin-left: 15px;
    }

    .personal-details {
        align-items: center;
        padding: 12px;
        margin-bottom: 5px;
        margin-top: 15px;
        display: block;
        color: #16259a;
        padding: 10px;
        text-decoration: none;
        font-size: 14px;
        text-align: left;
        font-family: system-ui;
        font-weight: 500;
        align-items: center;
        margin-left: 10px;
    }
    .Logout {
        align-items: center;
        padding: 5px;
        margin-bottom: 5px;
        margin-top: 200px;
    
    }
    .logoutbtn{
        display: block;
        color: #0046Fa;
        text-align: center;
        font-family: system-ui;
        padding-bottom: 5px;
        padding-top: 0px;
        font-weight: 500;
        font-size: 14px;
        padding-left: 10px;
        padding-right: 10px;
        text-decoration: none;
        text-align: left;
        margin-left: 10px;
    }
    .logoutbtn:hover {
        background-color: #007aff26;
        color: black;
    }
    .logoutbtn:active{
        background-color: #007aff80;
        color: black;
    }

    .status-container {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 5px;
      position: fixed;
      top: 210px;
      left: 250px;
      right: 10px;
      z-index: 1; /* Lower z-index so modal appears above */
        }
        
        .dash-item {
          border: 1px solid #ddd;
          border-radius: 10px;
          padding: 15px;
          margin: 5px;
          height: 80px;
          width: 180px;
          text-align: center;
          cursor: pointer;
          transition: transform 0.3s ease;
          background-color: #ffffff;
        }
        
        .dash-item:hover {
          transform: scale(1.05);
          background-color: #e0e4e8; 
        }

</style>

</body>
</html>
