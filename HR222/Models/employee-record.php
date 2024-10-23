<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "recruitmentdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Fetch records
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT id, employee_name, training_program, evaluator, development, date_given, remarks FROM training_performance";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["employee_name"]) . "</td>
                    <td>" . htmlspecialchars($row["training_program"]) . "</td>
                    <td>" . htmlspecialchars($row["evaluator"]) . "</td>
                    <td>" . htmlspecialchars($row["development"]) . "</td>
                    <td>" . htmlspecialchars($row["date_given"]) . "</td>
                    <td>" . htmlspecialchars($row["remarks"]) . "</td>
                    <td>
                        <button onclick='editRecord(" . $row["id"] . ")'>Edit</button>
                        <button onclick='deleteRecord(" . $row["id"] . ")'>Delete</button>
                        <button onclick='archiveRecord(" . $row["id"] . ")'>Archive</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No records found</td></tr>";
    }
}

// Handle POST requests for different actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        // Add new record
        $employeeName = $_POST['employeeName'];
        $trainingProgram = $_POST['trainingProgram'];
        $evaluator = $_POST['evaluator'];
        $development = $_POST['development'];
        $dateGiven = $_POST['dateGiven'];
        $remarks = $_POST['remarks'];

        $query = "INSERT INTO training_performance (employee_name, training_program, evaluator, development, date_given, remarks) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssss', $employeeName, $trainingProgram, $evaluator, $development, $dateGiven, $remarks);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Record added successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add record: ' . $stmt->error]);
        }
        
        $stmt->close();
    } elseif ($action === 'edit') {
        // Edit existing record
        $id = $_POST['id'];
        $employeeName = $_POST['employeeName'];
        $trainingProgram = $_POST['trainingProgram'];
        $evaluator = $_POST['evaluator'];
        $development = $_POST['development'];
        $dateGiven = $_POST['dateGiven'];
        $remarks = $_POST['remarks'];

        $query = "UPDATE training_performance SET employee_name = ?, training_program = ?, evaluator = ?, development = ?, date_given = ?, remarks = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssssi', $employeeName, $trainingProgram, $evaluator, $development, $dateGiven, $remarks, $id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Record updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update record: ' . $stmt->error]);
        }

        $stmt->close();
    } elseif ($action === 'delete') {
        // Delete record
        $id = $_POST['id'];
        $deleteQuery = "DELETE FROM training_performance WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param('i', $id);
        
        if ($deleteStmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete record: ' . $deleteStmt->error]);
        }
        
        $deleteStmt->close();
    } elseif ($action === 'archive') {
        // Archive logic (you might want to set a flag or move to another table)
        $id = $_POST['id'];
        $archiveQuery = "UPDATE training_performance SET archived = 1 WHERE id = ?";
        $archiveStmt = $conn->prepare($archiveQuery);
        $archiveStmt->bind_param('i', $id);
        
        if ($archiveStmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Record archived successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to archive record: ' . $archiveStmt->error]);
        }

        $archiveStmt->close();
    }
}

// Close the database connection
$conn->close();
?>
