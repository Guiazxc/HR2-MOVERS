<?php

class ConnectionDb
{
    private static $host = 'localhost';
    private static $username = 'root';
    private static $password = '';
    private static $dbName = 'recruitmentdb';
    public static $conn;

    // Create method
    public static function DbConnection()
    {
        self::$conn = new mysqli(self::$host, self::$username, self::$password, self::$dbName);

        // Check if we have an error
        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
        return self::$conn;
    }
}

// Establish the database connection
$conn = ConnectionDb::DbConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $name = $_POST['name'];
    $id = $_POST['id'];

    if ($action == 'accept') {
        // Update the onboarding_status table with the interview, application, and onboarding statuses
        $insert_sql = "
            INSERT INTO onboarding_status (name, interview_status, application_status, onboarding_status) 
            VALUES (?, 'INITIAL INTERVIEW', 'ON PROCESS', 'PRE-BOARDING')";
        
        // Prepare the statement for inserting into onboarding_status
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("s", $name);
        
        // Update the status in the screening_selection table
        $update_sql = "
            UPDATE screening_selection 
            SET Status = 'ONGOING'
            WHERE id = ?";
        
        // Prepare the statement for updating screening_selection
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $id);
        
        // Perform the database operations for accept
        if ($stmt->execute() && $update_stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Applicant has been accepted.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
        }
    } elseif ($action == 'reject') {
        // Update the status in the screening_selection table to 'REJECTED'
        $update_sql = "UPDATE screening_selection SET Status='REJECTED' WHERE id=?";
        
        // Prepare the statement for rejecting the application
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $id);
        
        // Perform the database operation for reject
        if ($update_stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Applicant has been rejected.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
        }
    }
}

// Close the connection
$conn->close();
?>
