<?php
// add_achievement.php

// Connect to the database
$conn = new mysqli("localhost", "root", "", "recruitmentdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted data
    $achievement = $_POST['achievement'] ?? '';
    $dateGiven = $_POST['date_given'] ?? '';
    $givenBy = $_POST['given_by'] ?? '';
    $employeeName = $_POST['employee_name'] ?? '';

    // Validate input
    if (!empty($achievement) && !empty($dateGiven) && !empty($givenBy) && !empty($employeeName)) {
        // Prepare and execute SQL query
        $stmt = $conn->prepare("INSERT INTO achievements (employee_name, achievement, date_given, given_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $employeeName, $achievement, $dateGiven, $givenBy);

        if ($stmt->execute()) {
            // Check how many rows were affected
            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No rows affected.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

$employeeName = $_POST['employee_name'] ?? '';

if (!empty($employeeName)) {
    $stmt = $conn->prepare("SELECT achievement, date_given, given_by FROM achievements WHERE employee_name = ?");
    $stmt->bind_param('s', $employeeName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['achievement']) . "</td>
                    <td>" . htmlspecialchars($row['date_given']) . "</td>
                    <td>" . htmlspecialchars($row['given_by']) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No achievements found.</td></tr>";
    }

    $stmt->close();
} else {
    echo "<tr><td colspan='3'>Invalid employee name.</td></tr>";
}


$conn->close();
