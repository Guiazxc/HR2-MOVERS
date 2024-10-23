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
    <link rel="stylesheet" type="text/css" href="css/onbordingstyles.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- ajax cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- sweet alert cdn -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        button {
            border: none;
            padding: 10px;
            background-color: #a6c4e5;
            border-radius: 10px;
        }

        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Could be more or less, depending on screen size */
            border-radius: 10px;
            text-align: center;
        }

        .modal-content input {
            padding: 10px;
            outline: none;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #Job_offer_status {
            padding: 10px;
        }

        select {
            padding: 10px;
        }

        .icon {
            margin-right: 5px; /* Space between icon and text */
        }
    </style>
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
            <a href="dashboard.php" class="dashboard"><i class="fas fa-tachometer-alt icon"></i>DASHBOARD</a>
        </div>

        <div class="recruitmentSection">
            <a href="./Job_offer.php" class="m-recruitment"><i class="fas fa-user-plus icon"></i>RECRUITMENT AND ONBOARDING</a>
        </div> 
        
        <div class="trainingSection">
            <a href="module3.php" class="trainAndDev"><i class="fas fa-chalkboard-teacher icon"></i>TRAINING MANAGEMENT</a>
        </div>

        <div class="performanceSection">
            <a href="module2.php" class="performance"><i class="fas fa-chart-line icon"></i>PERFORMANCE MANAGEMENT</a>
        </div>

       
        <div class="Logout">
        <a href="logout.php" class="logoutbtn">
        <i class="fas fa-sign-out-alt icon"></i> LOG OUT
        </a>
         </div>
    </div>

    <div class="buttonContainer">
        <a href="./Job_offer.php" class="btn1"><i class="fas fa-briefcase icon"></i>Job Offers</a>
        <a href="screening-selection.php" class="btn2"><i class="fas fa-users icon"></i>Screening and Selection</a>
        <a href="onboarding-status.php" class="onboarding-btn3"><i class="fas fa-user-check icon"></i>Onboarding Status</a>
        <input type="text" class="searchBar" placeholder="Search">
        <button class="searchBtn"><i class="fas fa-search"></i></button>
    </div>

    <table class="onboarding-container">
        <thead>
            <tr>
                <th>Name</th>
                <th>Interview Status</th>
                <th>Application Status</th>
                <th>Onboarding Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once './Models/Onboarding_status.php';
            global $conn;
            $Onboard = new Onboarding_status($conn);
            $Onboard->DisplayOnboarding();
            ?>
        </tbody>
    </table>

    <script>
        // Event for update btn
        $(document).on('click', '#Update_btn', function (event) {
            $.ajax({
                url: './Models/Onboarding_status.php',
                type: "post",
                data: {id: event.target.value},
                success: function (data, status) {
                    $('#updateModal_').remove();
                    $('body').append(data)
                    $('#updateModal_').show();
                    $('.close').on('click', function () {
                        $('#updateModal_').hide();
                    });
                }
            });
        });

        var interview_status  = '';
        var application_status = '';
        var onboarding_status = '';

        $(document).on('change', '#interview_status', function (event) {
            interview_status = event.target.value;
        });

        $(document).on('change', '#application_status', function (event) {
            application_status = event.target.value;
        });

        $(document).on('change', '#onboarding_status', function (event) {
            onboarding_status = event.target.value;
        });

        // Event for save btn
        $(document).on('click', '#Save_button', function (event) {
           var app_status = $('#app_status').val();  // Capture selected application status
           var view_status = $('#view_status').val();  // Capture interview status
           var onboard_status = $('#onboard_status').val();  // Capture onboarding status

             var Data = {
             Save_id: event.target.value,  // The ID of the row being updated
             interview_status: interview_status || view_status,  // Default to current if no change
             application_status: application_status || app_status,  // Default to current if no change
             onboarding_status: onboarding_status || onboard_status  // Default to current if no change
             };

            // Making AJAX request to save data
                 $.ajax({
                 url: './Models/Onboarding_status.php',  // Update path if necessary
                 type: "POST",
                 data: Data,
                 dataType: 'json',
                 encode: true,
                 success: function (res) {
                if (res.success == true) {
                  Swal.fire({
                    title: "Success!",
                    text: res.message,
                    icon: "success"
                 });
                setTimeout(() => { window.location.reload() }, 2000);  // Reload the page after success
                      }
                   }
              });
        });


        $(document).ready(function () {
            // Handle the delete
            $(document).on('click', '#Delete_btn', function (event) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, send the AJAX request to delete
                        $.ajax({
                            url: './Models/Onboarding_status.php',
                            type: 'POST',
                            data: {delete_Id: event.target.value},
                            dataType: 'json',
                            encode: true,
                            success: function (res) {
                                console.log(res);
                                if (res.success === true) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: res.message,
                                        icon: "success"
                                    });
                                    setTimeout(() => { window.location.reload() }, 2000);
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
