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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talent Management</title>
    <link rel="stylesheet" type="text/css" href="css/training-performance.css">
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Ajax CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Sweet Alert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="header">
    <span></span>
    <img src="assets/logo.png" alt="Logo">
</div>

<div class="container">
    <div class="photo">
        <img src="assets/logo.png" alt="Company Logo">
    </div>
    <!-- Sidebar navigation -->
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
        <a href="worked-hours.php" class="m-performance">
            <i class="fas fa-chart-line icon"></i> PERFORMANCE MANAGEMENT
        </a>
    </div>
    
    <div class="Logout">
        <a href="login.php" class="logoutbtn">
            <i class="fas fa-sign-out-alt icon"></i> LOG OUT
        </a>
    </div>
</div>

<div class="buttonContainer">
<a href="worked-hours.php" class="menu1">
                <i class="fas fa-clock"></i> Worked Hours
            </a>
            <a href="achievement.php" class="menu2">
                <i class="fas fa-trophy"></i> Achievement
            </a>  
            <a href="training-performance.php" class="menu3">
                <i class="fas fa-clipboard-check"></i> Training Performance
            </a>
        <input type="text" class="searchBar" placeholder="Search">
        <button class="searchBtn">
            <i class="fas fa-search icon"></i>
        </button>
</div>

        <div class="div2">
            <!-- Add Record Button -->
            <button id="btn_add_record" class="add-btn"><i class="fas fa-plus"></i> ADD RECORD</button>

            <!-- Add Modal -->
            <div id="addRecordModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeModal">&times;</span>
                    <h2>Add Record</h2>
                    <form id="addRecordForm">
                        <label for="employeeName">Employee Name:</label>
                        <input type="text" id="employeeName" name="employeeName" required>

                        <label for="trainingProgram">Training Program:</label>
                        <input type="text" id="trainingProgram" name="trainingProgram" required>

                        <label for="evaluator">Evaluator:</label>
                        <input type="text" id="evaluator" name="evaluator" required>

                        <label for="development">Development:</label>
                        <input type="text" id="development" name="development" required>

                        <label for="dateGiven">Date Given:</label>
                        <input type="date" id="dateGiven" name="dateGiven" required>

                        <label for="remarks">Remarks:</label>
                        <select id="remarks" name="remarks" required>
                            <option value="Success">Successful</option>
                            <option value="Failed">Failed</option>
                        </select>

                        <button type="submit" id="submitRecord" class="submitBtn">Add Record</button>
                    </form>
                </div>
            </div>
        </div>

<div class="table-div">
    <table class="employee-performance-container">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Training Program</th>
                <th>Evaluator</th>
                <th>Development</th>
                <th>Date Given</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php include 'Models/employee-record.php'; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        // Show the modal when the "Add Record" button is clicked
        $('#btn_add_record').click(function() {
            $('#addRecordModal').css('display', 'block');
        });

        // Close the modal when the "x" is clicked
        $('#closeModal').click(function() {
            $('#addRecordModal').css('display', 'none');
        });

        // Close the modal when clicking outside of the modal
        $(window).click(function(event) {
            if ($(event.target).is('#addRecordModal')) {
                $('#addRecordModal').css('display', 'none');
            }
        });

        // Handle form submission
        $('#addRecordForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Gather form data
            var employeeName = $('#employeeName').val();
            var trainingProgram = $('#trainingProgram').val();
            var evaluator = $('#evaluator').val();
            var development = $('#development').val();
            var dateGiven = $('#dateGiven').val();
            var remarks = $('#remarks').val();

            // Send the data to the server via AJAX
            $.ajax({
                url: 'Models/employee-record.php', // Your PHP script to handle the record addition
                type: 'POST',
                data: {
                    employeeName: employeeName,
                    trainingProgram: trainingProgram,
                    evaluator: evaluator,
                    development: development,
                    dateGiven: dateGiven,
                    remarks: remarks
                },
                dataType: 'json', // Expecting JSON response
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Record added successfully!');
                        $('#addRecordModal').css('display', 'none'); // Close the modal
                        location.reload(); // Reload the page to see the new record in the list
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to add record. Please try again.');
                }
            });
        });
    });


    // JavaScript functions to handle Edit, Delete, and Archive actions

function editRecord(id) {
    // Logic to open a modal with the existing record details
    // You would typically populate a form with the current values
    console.log("Edit record with ID:", id);
}

function deleteRecord(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        fetch('employee-record.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: 'delete', id: id }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert("Record deleted successfully.");
                location.reload(); // Reload the page to see the changes
            } else {
                alert("Error deleting record: " + data.message);
            }
        });
    }
}

function archiveRecord(id) {
    if (confirm("Are you sure you want to archive this record?")) {
        fetch('employee-record.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: 'archive', id: id }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert("Record archived successfully.");
                location.reload(); // Reload the page to see the changes
            } else {
                alert("Error archiving record: " + data.message);
            }
        });
    }
}
</script>

</body>
</html>
