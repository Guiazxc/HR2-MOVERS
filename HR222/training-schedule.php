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
    <link rel="stylesheet" type="text/css" href="css/trainingsched.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
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
            <a href="module3.php" class="m-trainAndDev"><i class="fas fa-chalkboard-teacher icon"></i>TRAINING MANAGEMENT</a>
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
        <a href="training-schedule.php" class="tp-btn3train"><i class="fas fa-calendar-alt icon"></i>Training Schedule</a>
        <a href="training-status.php" class="btn2train"><i class="fas fa-check-circle icon"></i>Training Status</a>
        <input type="text" class="searchBar" placeholder="Search">
        <button class="searchBtn"><i class="fas fa-search"></i></button>
    </div>

    <table class="tsched-container">
        <thead>
            <tr>
                <th>Name</th>
                <th>Training Program</th>
                <th>Starting Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include './Models/training_schedule.php';
            global $conn;
            $dis = new training_schedule($conn);
            $dis->DisplaySchedule();
            ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $(document).on('click', '#Update_btn', function () {
                var id = $(this).val(); // Get the ID from the button

                $.ajax({
                    url: './Models/training_schedule.php',  // Your PHP file that handles fetching the schedule
                    type: 'POST',
                    data: {
                        id: id,
                        action: "get_schedule" // Use a unique action to identify this request
                    },
                    success: function (response) {
                        // Remove any existing modals
                        $('#scheduleModal_' + id).remove();
                        // Append the new modal from the AJAX response
                        $('body').append(response);
                        // Show the modal
                        $('#scheduleModal_' + id).show();

                        // Close modal when clicking on the close button
                        $('.close').on('click', function () {
                            $('#scheduleModal_' + id).hide();
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error: " + error);
                        alert('An error occurred while fetching the training schedule.');
                    }
                });
            });

            $(document).on('click', '.save_button', function () {
                var id = $(this).val(); // Get the ID from the button
                var name = $('#name_' + id).val();
                var training_program = $('#training_program_' + id).val();
                var starting_date = $('#starting_date_' + id).val();
                var end_date = $('#end_date_' + id).val();

                $.ajax({
                    url: './Models/training_schedule.php',  // Your PHP file that handles saving the schedule
                    type: 'POST',
                    data: {
                        id: id,
                        name: name,
                        training_program: training_program,
                        starting_date: starting_date,
                        end_date: end_date,
                        action: "save_schedule" // Use a unique action to identify this request
                    },
                    success: function (response) {
                        alert(response); // Display the response message
                        // Close modal when clicking on the close button
                        $('.close').on('click', function () {
                            $('#scheduleModal_' + id).hide();
                        });
                        // Optionally, refresh the schedule display here
                        location.reload(); // Reload the page to see updated data
                    },
                    error: function (xhr, status, error) {
                        console.error("Error: " + error);
                        alert('An error occurred while saving the training schedule.');
                    }
                });
            });

            $(document).on('click', 'button[id^="delete_button_"]', function () {
                var id = $(this).val(); // Get the ID from the button

                // Show confirmation dialog
                var confirmDelete = confirm("Are you sure you want to delete this schedule?");

                if (confirmDelete) {
                    // Proceed with AJAX request if user confirms
                    $.ajax({
                        url: './Models/training_schedule.php',  // Your PHP file that will handle the delete
                        type: 'POST',
                        data: {
                            id: id,
                            action: "delete_schedule" // Your action for deleting
                        },
                        success: function (response) {
                            alert(response);  // Display the server's response
                            location.reload(); // Reload the page after successful deletion
                        },
                        error: function (xhr, status, error) {
                            console.error("Error: " + error);
                            alert('An error occurred while deleting the training schedule.');
                        }
                    });
                } else {
                    // User canceled the action, do nothing
                    alert('Deletion canceled.');
                }
            });
        });
    </script>

</body>
</html>
