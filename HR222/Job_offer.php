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
    <link rel="stylesheet" type="text/css" href="css/module1styles.css">
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Ajax CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Sweet Alert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        button {
            border: none;
            padding: 10px;
            background-color: #a6c4e5;
            border-radius: 10px;
        }

        .icon {
            margin-right: 8px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
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

        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #Job_offer_status {
            padding: 10px;
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
        <a href="dashboard.php" class="dashboard"><i class="fas fa-tachometer-alt icon"></i> DASHBOARD</a>
    </div>

    <div class="recruitmentSection">
        <a href="./Job_offer.php" class="m-recruitment"><i class="fas fa-user-plus icon"></i> RECRUITMENT AND ONBOARDING</a>
    </div>  
    
    <div class="trainingSection">
        <a href="module3.php" class="trainAndDev"><i class="fas fa-chalkboard-teacher icon"></i> TRAINING MANAGEMENT</a>
    </div>

    <div class="performanceSection">
        <a href="worked-hours.php" class="performance"><i class="fas fa-chart-line icon"></i> PERFORMANCE MANAGEMENT</a>
    </div>

    <div class="Logout">
        <a href="logout.php" class="logoutbtn">
        <i class="fas fa-sign-out-alt icon"></i> LOG OUT
        </a>
    </div>
</div>

<div class="buttonContainer">
    <a href="Job_offer.php" class="job-btn1">
        <i class="fas fa-briefcase icon"></i> Job Offers
    </a>
    <a href="screening-selection.php" class="btn2">
        <i class="fas fa-users icon"></i> Screening and Selection
    </a>
    <a href="onboarding-status.php" class="btn3">
        <i class="fas fa-user-check icon"></i> Onboarding Status
    </a>
    <input type="text" class="searchBar" placeholder="Search">
    <button class="searchBtn"><i class="fas fa-search"></i></button>
    <!-- Add Job Button -->
    <button id="btn_add_job" class="add_btn"><i class="fas fa-plus"></i> ADD JOB</button>

    <!-- Add Job Modal -->
    <div id="addJobModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Add Job</h2>
            <form id="addJobForm">
                <label for="jobName">Job Name:</label>
                <input type="text" id="jobName" name="jobName" required>
            
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            
                <button type="submit" id="submitJob">Add Job</button>
            </form>
        </div>
    </div>
</div>

<table class="offer-container">
    <thead>
        <tr>
            <th>Status</th>
            <th>Job</th>
            <th>Applicant</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    include_once './Models/JobOffer.php';
    global $conn;
    $jobList = new JobOffer($conn);
    $jobList->DisplayJob_offer();
    ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        // Add Job Modal functionality
        $('#btn_add_job').click(function() {
            $('#addJobModal').css('display', 'block');
        });

        $('#closeModal').click(function() {
            $('#addJobModal').css('display', 'none');
        });

        $(window).click(function(event) {
            if ($(event.target).is('#addJobModal')) {
                $('#addJobModal').css('display', 'none');
            }
        });

        // Handle job form submission via AJAX
        $('#addJobForm').submit(function(event) {
            event.preventDefault();

            var jobName = $('#jobName').val();
            var status = $('#status').val();

            $.ajax({
                url: 'Models/add_job.php',
                type: 'POST',
                data: { jobName: jobName, status: status },
                success: function(response) {
                    Swal.fire('Success!', 'Job added successfully!', 'success');
                    $('#addJobModal').css('display', 'none');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    Swal.fire('Error!', 'Failed to add job. Please try again.', 'error');
                }
            });
        });

        // Delete job event
        $(document).on('click', '#delete_btn', function(event) {
            var jobId = event.target.value;

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
                    $.ajax({
                        url: './Models/JobOffer.php',
                        type: 'POST',
                        data: { id: jobId },
                        dataType: 'json',
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire('Deleted!', res.message, 'success');
                                setTimeout(() => { window.location.reload(); }, 2000);
                            }
                        }
                    });
                }
            });
        });

        // Update job event
        $(document).on('click', '#btn_update', function(e) {
            $.ajax({
                url: './Models/JobOffer.php',
                type: 'POST',
                data: { Job_id: e.target.value },
                success: function(data) {
                    $('#updateModal').remove();
                    $('body').append(data);
                    $('#updateModal').show();

                    $('.close').on('click', function() {
                        $('#updateModal').hide();
                    });
                }
            });
        });

       // for saving updated info
// event for select status

 var UpdatedStatus = '';
$(document).on('change','#Job_offer_status',function (event){
    UpdatedStatus = event.target.value;
})

$(document).on('click','#confirmUpdateconfirmUpdate',function (){
   var Data = {
       Save_status: UpdatedStatus,
       Job_id_save: event.target.value,
       job_name: $('#updateInput').val()
   }

   // ajax request to save the data
    $.ajax({
        url: "./Models/JobOffer.php",
        type: 'POST',
        data: Data,
        dataType: 'json',
        encode: true,
        success: function (res){
            if (res.success == true){
                Swal.fire({
                    title: "Success!",
                    text: res.message,
                    icon: "success"
                });
                setTimeout(() =>{window.location.reload()},2000)
            }
        }
    })
})
})

</script>

</body>
</html>
