<!DOCTYPE html>
<html>
<head>
    <title>Talent Management</title>
    <link rel="stylesheet" type="text/css" href="css/screeningstyles.css">
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

    .icon {
        margin-right: 5px; /* Space between icon and text */
    }
</style>

<body>

    <div class="header">
        <span>Movers</span>
        <img src="assets/logo.png" alt="Logo">
    </div>

    <div class="container">
        <div class="photo">
            <img src="assets/logo.png">
        </div>

        <div class="dashboardSection">
            <a href="dashboard.php" class="dashboard"><i class="fas fa-tachometer-alt icon"></i>Dashboard</a>
        </div>

        <div class="recruitmentSection">
            <a href="./Job_offer.php" class="m-recruitment"><i class="fas fa-user-plus icon"></i>RECRUITMENT AND ONBOARDING</a>
        </div>  
        
        <div class="trainingSection">
            <a href="module3.php" class="trainAndDev"><i class="fas fa-chalkboard-teacher icon"></i>TRAINING AND DEVELOPMENT MANAGEMENT</a>
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
        <a href="Job_offer.php" class="btn1"><i class="fas fa-briefcase icon"></i>Job Offers</a>
        <a href="screening-selection.php" class="screening-btn2"><i class="fas fa-users icon"></i>Screening and Selection</a>
        <a href="onboarding-status.php" class="btn3"><i class="fas fa-user-check icon"></i>Onboarding Status</a>
        <input type="text" class="searchBar" placeholder="Search">
        <button class="searchBtn"><i class="fas fa-search"></i></button>
    </div>

    <table class="screening-container">
    <thead>
        <tr>
            <th>Name</th>
            <th>Applied Position</th>
            <th>Age</th>
            <th>Email</th>
            <th>Resume</th>
            <th>Status</th>
            <th>Action</th> <!-- Added Action Column -->
        </tr>
    </thead>
    <tbody>
        <?php
        include './Models/Apply.php';
        $list = new Apply();
        $list->DisplayList_screening();

        ?>
    </tbody>
</table>



    <!-- This div is where the PDF will be displayed on the same page -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>View Resume</h2>
            <div id="pdfViewer"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle Accept button click
        $('.btn_accept').click(function() {
            var applicantName = $(this).data('name');
            var applicantId = $(this).data('id');
            
            $.ajax({
                url: 'Models/process_application.php',
                type: 'POST',
                data: {
                    action: 'accept',
                    name: applicantName,
                    id: applicantId
                },
                success: function(response) {
                    alert('Applicant ' + applicantName + ' has been accepted.');
                    location.reload();  // Reload page to see updated status
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        // Handle Reject button click
        $('.btn_reject').click(function() {
            var applicantName = $(this).data('name');
            var applicantId = $(this).data('id');
            
            $.ajax({
                url: 'Models/process_application.php',
                type: 'POST',
                data: {
                    action: 'reject',
                    name: applicantName,
                    id: applicantId
                },
                success: function(response) {
                    alert('Applicant ' + applicantName + ' has been rejected.');
                    location.reload();  // Reload page to see updated status
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>


   


    <script>
        $(document).ready(function() {
            $(document).on('click', '#btn_view', function (e) {
                $('#pdfViewer').html(
                    `
                    <embed src='./Models/Upload_resume/${e.target.value}' width='100%' height='1000px' type='application/pdf'>
                    `
                );
                // Remove any existing modals before appending a new one
                $('#updateModal').show();
                // Bind the close button event after the modal has been appended
                $('.close').on('click', function () {
                    $('#updateModal').hide();
                });
            });
        });
    </script>



</body>
</html>
