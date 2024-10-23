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
    <link rel="stylesheet" type="text/css" href="css/trainingstatus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--ajax cdn-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
            <a href="./Job_offer.php" class="recruitment"><i class="fas fa-user-plus icon"></i>RECRUITMENT AND ONBOARDING</a>
        </div>   

        <div class="trainingSection">
            <a href="module3.html" class="m-trainAndDev"><i class="fas fa-chalkboard-teacher icon"></i>TRAINING MANAGEMENT</a>
        </div>
  
        <div class="performanceSection">
            <a href="worked-hours.php" class="performance"><i class="fas fa-chart-line icon"></i>PERFORMANCE MANAGEMENT</a>
        </div>
  
       

        <div class="Logout">
          <a href="logout.php" class="logoutbtn">
          <i class="fas fa-sign-out-alt icon"></i> LOG OUT
          </a>
        </div>
    </div>
  
    <div class="buttonContainer">
        <a href="module3.php" class="btn1train"><i class="fas fa-book icon"></i>Training Program</a>
        <a href="training-schedule.php" class="btn3train"><i class="fas fa-calendar-alt icon"></i>Training Schedule</a>
        <a href="training-status.php" class="tp-btn2train"><i class="fas fa-check-circle icon"></i> Training Status</a>
        <input type="text" class="searchBar" placeholder="Search">
        <button class="searchBtn"><i class="fas fa-search"></i></button>
    </div>
  
    <table class="tscointainer">
        <thead>
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Training Program</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include './Models/training_status.php';
            global $conn;
            $t_status = new training_status($conn);
            $t_status->DisplayTrainingStatus();
            ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function (){
            $(document).on("click", '#Update_btn', function (e) {
                var id = e.target.value;
                console.log(id);

                $.ajax({
                    url: './Models/training_status.php',
                    type: 'post',
                    data: {
                        id: id,
                        action: "update"
                    },
                    success: function (data, status) {
                        console.log(status);
                        // Remove any existing modals
                        $('#updateModal_' + id).remove();
                        // Append the new modal from the AJAX response
                        $('body').append(data);
                        // Show the modal
                        $('#updateModal_' + id).show();

                        // Close modal when clicking on the close button
                        $('.close').on('click', function () {
                            $('#updateModal_' + id).hide();
                        });
                    }
                });
            });

            $(document).on('click', 'button[id^="Save_button_"]', function () {
                var id = $(this).val(); // Get the ID from the button

                // Collect the updated values from the modal
                var name = $('#name' + id).val();
                var t_program = $('#training_program_' + id).val();
                var start_date = $('#start_date_' + id).val();
                var end_date = $('#end_date_' + id).val();
                var status = $('#status_' + id).val();
                console.log(t_program)

                // Send the data via AJAX to the server
                $.ajax({
                    url: './Models/training_status.php',  // Your PHP file that will handle the update
                    type: 'POST',
                    data: {
                        id: id,
                        name: name,
                        t_program: t_program,
                        start_date: start_date,
                        end_date: end_date,
                        status: status,
                        action: "save_"
                    },
                    success: function (response) {
                        alert(response);  // Display the server's response
                        location.reload(); // Reload the page after successful update
                    },
                    error: function (xhr, status, error) {
                        console.error("Error: " + error);
                        alert('An error occurred while updating the training status.');
                    }
                });
            });

            // Function to close the modal
            function closeModal(id) {
                $('#updateModal_' + id).hide();
            }

            $(document).on('click', 'button[id^="delete_button_"]', function () {
                var id = $(this).val();  // Get the ID from the button

                // Confirm deletion before proceeding
                if (confirm('Are you sure you want to delete this training status?')) {
                    // Send the delete request via AJAX
                    $.ajax({
                        url: './Models/training_status.php',  // PHP file that will handle the delete
                        type: 'POST',
                        data: {
                            id: id,
                            action: "delete"
                        },
                        success: function (response) {
                            alert(response);  // Display the server's response
                            location.reload(); // Reload the page to reflect the deletion
                        },
                        error: function (xhr, status, error) {
                            console.error("Error: " + error);
                            alert('An error occurred while deleting the training status.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
