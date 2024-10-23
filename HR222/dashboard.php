<?php
session_start();  // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Talent Management</title>
    <link rel="stylesheet" type="text/css" href="css/dashboardstyles.css">
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="header">
    <span></span>
    <img src="assets/logo.png" alt="Logo">
</div>

<div class="container">
    <div class="photo">
        <img src="assets/logo.png">
    </div>
    
    <div class="dashboardSection">
        <a href="dashboard.php" class="dashboard">
            <i class="fas fa-tachometer-alt icon"></i> DASHBOARD
        </a>
    </div>

    <div class="recruitmentSection">
        <a href="./Job_offer.php" class="recruitment">
            <i class="fas fa-user-tie icon"></i> RECRUITMENT AND ONBOARDING
        </a>
    </div>   

    <div class="trainingSection">
        <a href="module3.php" class="trainAndDev">
            <i class="fas fa-book-open icon"></i> TRAINING MANAGEMENT
        </a>
    </div>

    <div class="performanceSection">
        <a href="worked-hours.php" class="performance">
            <i class="fas fa-chart-line icon"></i> PERFORMANCE MANAGEMENT
        </a>
    </div>

    <div class="Logout">
        <a href="logout.php" class="logoutbtn">
            <i class="fas fa-sign-out-alt icon"></i> LOG OUT
        </a>
    </div>
</div>

<div class="buttonContainer">
    <p class="d-text">Dashboard</p>
    <input type="text" class="searchBar" placeholder="Search">
    <button class="searchBtn"><i class="fas fa-search"></i></button>
</div>

<div class="dashboard-container">
    <div class="dash-item">1</div>
    <div class="dash-item">2</div>
    <div class="dash-item">3</div>
    <div class="dash-item">4</div>
    <div class="dash-item">5</div>
    <div class="dash-item">6</div>
</div>

</body>
</html>
