<?php


include_once 'config.php';
global $conn;

class JobOffer
{
    public $conn;
    // create constructor for connection
    public function __construct()
    {
        $this->conn  = ConnectionDb::DbConnection();
    }

    // create method to display the job offer list
    public  function DisplayJob_offer ()
    {
        $result = $this->conn->query("SELECT * FROM job_offers WHERE Delete_status = 'Active'");
        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['job_name'] . "</td>";
                echo "<td>" . $row['Applicant_count'] . "</td>";
                echo "<td>
                     <div>
                        <button id='btn_update' value='${row['id']}' class='edit'>Update</button>
                       <button id='delete_btn' value='${row['id']}' class='delete'>Delete</button>
                    </div>
                  </td>";
                echo "</tr>";

            }
        }else{
            echo "<th>No Data Available</th>";
        }

        $this->conn->close();
    }


    // create method for delete functionality
    public function Delete_job_offer($id)
    {
        $delete_ = "is_deleted";
        $query  = "UPDATE job_offers SET Delete_status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('si',$delete_,$id);
        if ($stmt->execute()){
            echo json_encode(['status' => 'success', true => 'job offer is successfully deleted']);
        }else{
            echo json_encode(['status' => false, 'message' => 'Failed to delete']);
        }
        $stmt->close();
        $this->conn->close();
    }


    // method for viewUpdate
    public function ViewUpdate($id)
    {
        $Query  = "SELECT * FROM job_offers WHERE id = ?";
        $stmt = $this->conn->prepare($Query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()){
            echo '
        <div id="updateModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Update Job Offer</h2>
                <p>Please enter the new details below:</p>
                <div style="display: flex; flex-direction: column; gap: 10px">
                    <input type="text" value="' . $row['job_name'] . '" id="updateInput" placeholder="Enter new job details" required>
                    <select id="Job_offer_status">
                      <option selected value="'.$row['status'].'">Select Job Status( '.$row['status'].')</option>
                      <option value="CLOSE">CLOSE</option>
                      <option value="OPEN">OPEN</option>
                    </select>
                    <button  value=" '.$id.'" style="border-radius: 0; font-weight: bold; padding: 10px" id="confirmUpdateconfirmUpdate">Save</button>
                </div>
                <br><br>
            </div>
        </div>
        ';
        }
    }


    // method for Saving the updated JobOffer

    public function SavingJobOffer($job_name,$status,$id)
    {
       $query = "UPDATE job_offers SET job_name = ? ,status = ? WHERE id = ?";
       $stmt = $this->conn->prepare($query);
       $stmt->bind_param('ssi',$job_name,$status,$id);
       if ($stmt->execute()){
           echo json_encode(['success' => true,'message' => 'Successfully Updated']);
       }else{
           echo json_encode(['success' => false,'message' => 'Update Failed']);
       }
    }


    public function GeJobName()
    {
        $result = $this->conn->query("SELECT job_name FROM job_offers WHERE Delete_status = 'Active'");
        while ($row = $result->fetch_assoc()){
            echo '
              <option value="' . $row['job_name'] . '">' . $row['job_name'] . '</option>
            ';
        }
    }

}

// for delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
    $id = $_POST['id'];
    $DeleteJob_offer = new JobOffer($conn);
    $DeleteJob_offer->Delete_job_offer($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Job_id'])){
    $id = $_POST['Job_id'];

    // call the method
    $UpdateJob = new JobOffer($conn);
    $UpdateJob->ViewUpdate($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Job_id_save'])){

    $Job_id_save = $_POST['Job_id_save'];
    $jobName = $_POST['job_name'];
    $status = $_POST['Save_status'];

    $SaveUpdate = new JobOffer($conn);
    $SaveUpdate->SavingJobOffer($jobName,$status,$Job_id_save);

}