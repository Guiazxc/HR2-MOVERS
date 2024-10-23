<?php
class ConnectionDb
{
    private static $host = 'localhost';
    private static $username = 'root';
    private static $password = '';
    private static $dbName = 'recruitmentdb';
    public static $conn;

    public static function DbConnection()
    {
        self::$conn = new mysqli(self::$host, self::$username, self::$password, self::$dbName);

        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
        return self::$conn;
    }
}

$conn = ConnectionDb::DbConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trainingName = $_POST['trainingName'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $place = $_POST['place'];

    $query = "INSERT INTO training_program (training_name, date, time, place) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param('ssss', $trainingName, $date, $time, $place);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Program added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to Add Program: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
