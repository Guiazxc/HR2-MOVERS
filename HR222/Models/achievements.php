<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "recruitmentdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if we are fetching achievements (GET request)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // If we are fetching achievements for a specific employee
    if (isset($_GET['employee_name'])) {
        // Get the employee name from the AJAX request
        $employeeName = $_GET['employee_name'];

        // Fetch achievements for the selected employee
        $sql = "SELECT achievement, date_given, given_by FROM achievement WHERE employee_name = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing query: " . $conn->error;
            exit();
        }

        $stmt->bind_param("s", $employeeName);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are records
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['achievement']}</td>
                        <td>{$row['date_given']}</td>
                        <td>{$row['given_by']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No records found</td></tr>";
        }

        $stmt->close();
        $conn->close();
        exit();
    } else {
        // Fetch all employees if no specific employee is requested
        $sql = "SELECT employee_name, department FROM achievement GROUP BY employee_name";
        $result = $conn->query($sql);

        $employees = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $employees[] = $row; // Collect employees
            }
        }

        // Return the employees as JSON
        echo json_encode($employees);
        $conn->close();
        exit();
    }
}

// Check if we are adding a new record (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['employeeName'], $_POST['department'])) {
        $employeeName = $_POST['employeeName'];
        $department = $_POST['department'];

        // Prepare the insert query
        $query = "INSERT INTO achievement (employee_name, department) VALUES (?, ?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
            exit();
        }

        $stmt->bind_param('ss', $employeeName, $department);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Record added successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add record: ' . $stmt->error]);
        }

        // Close the statement and connection
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Required data missing.']);
    }
}

// Close the database connection at the end of the script
$conn->close();


error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Failed to add achievement.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (isset($_POST['achievement'], $_POST['date_given'], $_POST['given_by'])) {
        $achievement = $_POST['achievement'];
        $date_given = $_POST['date_given'];
        $given_by = $_POST['given_by'];

        // Example database insertion (make sure you have your DB connection)
        $sql = "INSERT INTO achievements (achievement, date_given, given_by) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $achievement, $date_given, $given_by);
        
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Achievement added successfully.';
        } else {
            $response['message'] = 'Database error: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = 'Missing required fields.';
    }
}

echo json_encode($response);
?>