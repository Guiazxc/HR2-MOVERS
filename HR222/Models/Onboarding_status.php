<?php
// include the database connection
include_once 'config.php';
// call the class and method
global $conn;
class Onboarding_status
{

    // create property
    public $conn;

    //creating constructor for conn
    public function __construct($conn)
    {
        $this->conn = $conn = ConnectionDb::DbConnection();
    }

    public function DisplayOnboarding()
    {
        $result = $this->conn->query("SELECT * FROM onboarding_status WHERE Delete_Status  = 'Active'");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['interview_status'] . "</td>";
                echo "<td>" . $row['application_status'] . "</td>";
                echo "<td>" . $row['onboarding_status'] . "</td>";
                echo "<td>
                    <div>
                        <button value='${row['id']}' style='background-color: #a6c4e5' id='Update_btn'>Update</button>
                        <button value='${row['id']}' style='background-color: #a6c4e5' id='Delete_btn'>Delete</button>
                    </div>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No Onboarding Data Available</td></tr>";
        }
    }


    // View update method

    public function ViewUpdate($id)
    {
        $query = "SELECT * FROM onboarding_status WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()){
            echo '
            
     <div id="updateModal_" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Onboarding Details</h2>
            <p>Please enter the new details below:</p>
            <div style="display: flex; flex-direction: column; gap: 10px">
                <select id="interview_status">
                    <option selected value="'.$row['interview_status'].'">Select interview Status( '.$row['interview_status'].')</option>
                    <option value="INITIAL INTERVIEW">INITIAL INTERVIEW</option>
                    <option value="FINAL INTERVIEW">FINAL INTERVIEW</option>
                </select>
                <input id="view_status" value="'.$row['interview_status'].'" style="display: none" type="text">
                <select id="application_status">
                    <option selected value="'.$row['application_status'].'">Select application status( '.$row['application_status'].')</option>
                    <option value="ON PROCESS">ON PROCESS</option>
                    <option value="TO BE CALL">TO BE CALL</option>
                    <option value="HIRED">HIRED</option>
                </select>
                 <input id="app_status" value="'.$row['application_status'].'" style="display: none" type="text">
                <select id="onboarding_status">
                    <option selected value="'.$row['onboarding_status'].'">Select Job Status( '.$row['onboarding_status'].')</option>
                    <option value="SELECT">SELECT</option>
                    <option value="PRE-BOARDING">PRE-BOARDING</option>
                    <option value="ORIENTATION">ORIENTATION</option>
                    <option value="TRAINING">TRAINING</option>
                    <option value="TRANSITION">TRANSITION</option>
                </select>
                <input id="onboard_status" value="'.$row['onboarding_status'].'" style="display: none" type="text">
                <button  value=" '.$id.'" style="border-radius: 0; font-weight: bold; padding: 10px" id="Save_button">Save</button>
            </div>
            <br><br>
        </div>
    </div>
            ';
        }

    }

    // method for saving updated onboard
    public function SavingOnboard($interview_status, $application_status, $onboarding_status, $id)
    {
        $query = "UPDATE onboarding_status SET interview_status = ?, application_status = ?, onboarding_status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sssi', $interview_status, $application_status, $onboarding_status, $id);
    
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Successfully Updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Update Failed']);
        }
    }
    

    // method for deleting

    public function Delete_Onboard($status_de,$id)
    {
        $query = "UPDATE onboarding_status SET Delete_Status = ? WHERE id  = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('si',$status_de,$id);
        if ($stmt->execute()){
            echo json_encode(['success' => true, 'message' => 'Successully Deleted']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed Delete']);
        }

    }

}

// Saving Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
    $id = $_POST['id'];
    $viewUpdate = new Onboarding_status($conn);
    $viewUpdate->ViewUpdate($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Save_id'])){
    $id = $_POST['Save_id'];
    $interview_status = $_POST['interview_status'];
    $application_status = $_POST['application_status'];
    $onboarding_status = $_POST['onboarding_status'];

    $Save_updated = new Onboarding_status($conn);
    $Save_updated->SavingOnboard($interview_status,$application_status,$onboarding_status,$id);
}

// handle the delete functionality
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete_Id'])){
    $Delete_fun = new Onboarding_status($conn);
    $status_de = "is_deleted";
    $delete_Id = $_POST['delete_Id'];
    $Delete_fun->Delete_Onboard($status_de,$delete_Id);
}

