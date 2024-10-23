<?php
include_once 'config.php';
global $conn;
class Apply
{
    // create property conn

    public $conn;

    // creating constructor

    public function __construct()
    {
        $this->conn = ConnectionDb::DbConnection();
    }

    // method for Applicant information

    public function Applicant_Information($name,$age,$Email,$SelectedJob,$resume)
    {
        $query = "INSERT INTO screening_selection(name, applied_position, age, email, document_path) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssiss',$name,$SelectedJob,$age,$Email,$resume);
        if ($stmt->execute()){
            echo json_encode(['status' => 'success' , 'message' => 'Thank You for Applying']);
        }else{
            echo json_encode(['status' => 'error' , 'message' => 'Failed To apply']);
        }
        $stmt->close();
        $this->conn->close();
    }

    // test
    public function DisplayList_screening()
    {
        $result = $this->conn->query("SELECT * FROM screening_selection");
        while ($row = $result->fetch_assoc()) {
            echo "
              <tr>
              <td>${row['name']}</td>
              <td>${row['applied_position']}</td>
               <td>${row['age']}</td>
              <td>${row['email']}</td>
              <td>
               <button class='viewPdf' id='btn_view' value='{$row['document_path']}' style='border: solid #3d52a0; padding: 5px; text-decoration: none; background-color: #3d52a0; color: white;'>Open</button>
              </td>
              <td>
              ${row['Status']}
              </td>
              <td>";
            
            // Check the status and display buttons accordingly
            if ($row['Status'] === 'ONGOING') {
                // Display View button if status is ONGOING
                echo "<a href='onboarding-status.php?id={$row['id']}' style='border: solid #3d52a0; padding: 5px; background-color: #3d52a0; color: white; text-decoration: none;'>View</a>";
            } else {
                // Display Accept and Reject buttons if status is not ONGOING
                echo "
                    <button class='btn_accept' data-name='{$row['name']}' data-id='{$row['id']}' style='border: solid green; padding: 5px; background-color: green; color: white;'>Accept</button>
                    <button class='btn_reject' data-name='{$row['name']}' data-id='{$row['id']}' style='border: solid red; padding: 5px; background-color: red; color: white;'>Reject</button>
                ";
            }
            
            echo "
              </td>
              </tr>
            ";
        }
    }
    
//

    public function ViewPdf($id)
    {
        // Fetch the document path from the database
        $result = $this->conn->query("SELECT document_path FROM screening_selection WHERE id = $id");

        // Check if the query returned a result
        if ($row = $result->fetch_assoc()) {
            $documentPath = $row['document_path'];

            // Output the embed tag to display the PDF
            echo "
        <embed src='../Models/Upload_resume/$documentPath' width='50%'  height='300px' type='application/pdf'>
        ";
        } else {
            echo "No document found for the provided ID.";
        }
    }

}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables
    $jobTitle = $_POST['SelectedJob']; // Use null coalescing operator to avoid undefined index
    $Name = $_POST['Name'] ;
    $Age = $_POST['Age'] ; // Default to 0 if not set
    $Email = $_POST['Email'] ;
    $Contact = $_POST['Contact_number'] ;
    $Resume = $_FILES['resume']['name'] ; // Handle resume file name

    $errors = []; // Array to hold error messages

    // Validate required fields
    if (empty($Name)) {
        $errors['Name'] = 'Please enter your name';
    }
    if (empty($Age)) {
            $errors['Age'] = 'Please enter your age';
    }

    if (empty($Email)) {
        $errors['Email'] = 'Please enter your email';
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $errors['Email'] = 'Please enter a valid email address';
    }

    if (empty($jobTitle) || $jobTitle === 'Select Job Position') {
        $errors['Job'] = 'Please select a job title';
    }

    if (empty($Resume)) {
        $errors['Resume'] = 'Please upload your resume';
    }
    if (empty($Contact)) {
            $errors['Contact'] = 'Please enter your contact number';
    }

    // Check if there are any errors
    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit; // Stop further execution if there are errors
    }

    // Handle the resume upload
    $uploadDir = './Upload_resume/';
    if (move_uploaded_file($_FILES['resume']['tmp_name'], $uploadDir . $Resume)) {
        // Create an instance of the Apply class and insert data
        $Applicant = new Apply();
        $Applicant->Applicant_Information($Name, $Age, $Email, $jobTitle, $Resume);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload resume']);
    }
}