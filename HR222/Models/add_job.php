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
    $jobName = $_POST['jobName'];

    // Prepare the insert query
    $query = "INSERT INTO job_offers (job_name, Delete_status) VALUES (?, 'Active')"; // Default status set to 'Active'
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param('s', $jobName); // Bind only jobName since status is hardcoded

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Job added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add job: ' . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
