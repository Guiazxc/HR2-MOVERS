<?php
session_start();  // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit();
}
?>

<?php 
// Database connection
$conn = new mysqli("localhost", "root", "", "recruitmentdb"); // Correct database name

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch worked_hours
$sql = "SELECT * FROM worked_hours";
$result = $conn->query($sql);

// Check if query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talent Management</title>
    <link rel="stylesheet" type="text/css" href="css/achievement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <!-- Add Employee Button -->
        <button id="btn_add_employee" class="add-btn"><i class="fas fa-plus"></i>ADD EMPLOYEE</button>

        <!-- Add Employee Modal -->
        <div id="addEmployeeModal" class="add-modal">
            <div class="add-modal-content">
                <span class="add-close" id="closeModal">&times;</span>
                <h3>Add Employee</h3>
                <form id="addEmployeeForm">
                    <label for="addemployeeName">Employee Name:</label>
                    <input type="text" id="addemployeeName" name="addemployeeName" required>

                    <label for="department">Department:</label>
                    <input type="text" id="department" name="department" required>

                    <button type="submit" id="submit" class="submitBtn">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Employee Cards Container -->
    <div class="employee-cards-container">
        <!-- Employee cards will be dynamically inserted here -->
    </div>

    <!-- Modal to show achievements -->
    <div id="achievementModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" id="closeAchievementModal">&times;</span>
            <h2 id="employeeName"></h2><!-- Display employee name -->
            <p id="employeeDepartment"></p> <!-- Display employee department -->
                       
            <!-- Add achievements Button -->
            <button id="btn_add_achievement" class="add-achievement"><i class="fas fa-plus"></i>ADD</button>

            <!-- Add achievement Modal -->
            <div id="addachievementModal" class="achievement-modal">
                <div class="achievement-modal-content">
                    <span class="achievement-close" id="closeAchievement">&times;</span>
                    <h3>Add Achievement Details</h3>
                    <form id="addAchievementForm">
                        <label for="achievement">Achievement:</label>
                        <input type="text" id="achievement" name="achievement" required>

                        <label for="date">Date Given:</label>
                        <input type="date" id="date" name="date" required>

                        <label for="given">Given By:</label>
                        <input type="text" id="given" name="given" required>

                        <button type="submit" id="submitAchievement" class="submitAchievementBtn">SUBMIT</button>
                    </form>
                </div>
            </div>

            <table class="achievement-table">
                <thead>
                    <tr>
                        <th>Achievements</th>
                        <th>Date Given</th>
                        <th>Given By</th>
                    </tr>
                </thead>
                <tbody id="achievementTableBody">
                    <!-- Fetched achievements data will be inserted here -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Show the Add Employee modal
        $('#btn_add_employee').click(function() {
            $('#addEmployeeModal').css('display', 'block');
        });

        // Close the Add Employee modal
        $('#closeModal').click(function() {
            $('#addEmployeeModal').css('display', 'none');
        });

        // Handle form submission via AJAX for adding employees
        $('#addEmployeeForm').submit(function(event) {
            event.preventDefault();
            var employeeName = $('#addemployeeName').val();
            var department = $('#department').val();

            $.ajax({
                url: 'Models/achievements.php',
                type: 'POST',
                data: { employeeName: employeeName, department: department },
                success: function(response) {
                    alert('Employee added successfully!');
                    $('#addEmployeeModal').css('display', 'none');
                    loadEmployees();
                },
                error: function() {
                    alert('Error adding employee.');
                }
            });
        });

        // Load employees dynamically
        function loadEmployees() {
            $.ajax({
                url: 'Models/achievements.php',
                type: 'GET',
                success: function(response) {
                    var employees = JSON.parse(response);
                    $('.employee-cards-container').empty();
                    employees.forEach(function(employee) {
                        var card = $('<div class="employee-card"></div>');
                        card.html('<h3>' + employee.employee_name + '</h3><p>' + employee.department + '</p>');
                        card.data('employee', employee);
                        card.click(function() {
                            $('#employeeName').text(employee.employee_name);
                            $('#employeeDepartment').text(employee.department);
                            loadAchievement(employee.employee_name);
                            $('#achievementModal').css('display', 'block');
                        });
                        $('.employee-cards-container').append(card);
                    });
                },
                error: function() {
                    console.error('Error loading employees.');
                }
            });
        }

        // Load achievements for a specific employee
        function loadAchievement(employee_name) {
            $.ajax({
                url: 'Models/achievements.php',
                type: 'GET',
                data: { employee_name: employee_name },
                success: function(response) {
                    $('#achievementTableBody').html(response);
                },
                error: function() {
                    console.error('Error loading achievements.');
                }
            });
        }

        // Show the Add Achievement modal
        $('#btn_add_achievement').click(function() {
            $('#addachievementModal').css('display', 'block');
        });

        // Close the Add Achievement modal
        $('#closeAchievement').click(function() {
            $('#addachievementModal').css('display', 'none');
        });

        // Close the Achievement modal
        $('#closeAchievementModal').click(function() {
            $('#achievementModal').css('display', 'none');
        });

        // Handle form submission via AJAX for adding achievements
        $('#addAchievementForm').submit(function(event) {
            event.preventDefault();
            var achievement = $('#achievement').val();
            var dateGiven = $('#date').val();
            var givenBy = $('#given').val();
            var employeeName = $('#employeeName').text();

            $.ajax({
                url: 'Models/add_achievement.php',
                type: 'POST',
                data: { achievement: achievement, date_given: dateGiven, given_by: givenBy, employee_name: employeeName },
                success: function(response) {
                    alert('Achievement added successfully!');
                    $('#addachievementModal').css('display', 'none');
                    loadAchievement(employeeName);
                },
                error: function() {
                    console.error('Error adding achievement.');
                }
            });
        });

        loadEmployees(); // Load employees on page load
    });

    function loadAchievement(employeeName) {
    $.ajax({
        url: 'Models/add_achievements.php', // Endpoint to fetch achievements for the given employee
        type: 'POST',
        data: { employee_name: employeeName },
        success: function(data) {
            $('#achievementTableBody').html(data); // Update the table body with new achievements
        },
        error: function(xhr, status, error) {
            console.error('Error loading achievements:', error);
        }
    });
}
    </script>
</body>
</html>
