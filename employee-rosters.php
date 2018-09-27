<?php
$page_title = "Employee's Rosters";

session_start();
//if user is not logged in, redirect to login.php
if(!$_SESSION['email']){
    header('location:index.php');
}

include('autoloader.php');

$rostm = new Roster();


$account_id = $rostm -> GetAccIdbySession($_SESSION['email']);
$shifts = $rostm -> GetShiftsAssignedBy($account_id);



?>

<!doctype html>
<html>
    <?php include('includes/head.php')?>
    <body>
        <?php include('includes/navbar2.php')?>
        
        <div class="jumbotron col-md-5 offset-md-3">
            <h1 class="display-4">Employee's Rosters</h1>
            
            </br>
             <a href='newroster.php'><button name="add" class="btn btn-warning mt-1 btn-block">Assign a new roster </button></a>
            
            </br>
          <?php
          if(count($shifts)>0){
          foreach ($shifts as $row){
          $shift_id = $row['shift_id'];
          $shift_time = $row['start_time'];
          $status = $row['shift_status'];
          $end_time = $row['end_time'];
          $location = $row['location'];
          $description = $row['description'];
          $assignedby = $row['fname'];
          $assignedbylast = $row['lname'];
          $start_date = date_create($shift_time);
          $end_date = date_create($end_time);
          $job_position = $row['job_position'];
          $assignedto_id = $row['assign_to'];
          
          $assignedto = $rostm -> GetAssignedTo($assignedto_id);
          
          
          echo "<div class=\"row align-items-center bg-white\">
                <div class=\"col\">
                    <p class=\"mb-auto\">";echo "Assigned to: "; echo $assignedto['fname']; echo " "; echo $assignedto['lname']; echo "</p>
                    <p class=\"mb-auto\">";echo "Date: "; echo date_format($start_date,"d F y"); echo "</p>
                    <p class=\"mb-auto\">";echo "Start Time: "; echo date_format($start_date,"h:i A"); echo"</p>
                    <p class=\"mb-auto\">$status</p>
                </div>
                     <div class=\"col-auto\">
                         <button class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal$shift_id\">View</button>
                     </div>
                 </div>
                 <hr>"; 
                 
                //MODAL PART 
                echo "<div class=\"modal fade\" id=\"modal$shift_id\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle\" aria-hidden=\"true\">
                    <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">
                      <div class=\"modal-content\">
                        <div class=\"modal-header\">
                          <h5 class=\"modal-title\" id=\"exampleModalCenterTitle\">$job_position</h5>
                          <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">&times;</span>
                          </button>
                        </div>
                        <div class=\"modal-body\">
                        <h6>"; 
                            echo date_format($start_date,"D d F Y");
                            echo 
                        "</h6> <hr>
                        <h6 class=\"bold\"> Status: </h6> <p>"; echo $status; echo "</p>"; 
                        
                        echo "<h6 class=\"bold\"> Assigned to: </h6> <p>"; echo $assignedto['fname']; echo " "; echo $assignedto['lname']; echo "</p>"; 
                        echo "<h6 class=\"bold\"> Time: </h6> <p>"; echo date_format($start_date,"h:i A"); echo " to "; echo date_format($end_date,"h:i A"); echo
                        "</p><h6 class=\"bold\"> Location: </h6><p>"; echo $location; 
                        echo "<h6 class=\"bold\"> Assigned by: </h6><p>"; echo "$assignedby $assignedbylast"; echo
                        "</p><h6 class=\"bold\"> Description: </h6><p>"; echo $description; echo
                        " </p>
                        </div>
                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-success\"><a href=\"rosterdetail.php?shift_id=$shift_id\">Edit</a></button>
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>";
                 
              }
          } else{
             echo "<div class=\"row bg-white\">
            <div class=\"col\">
                <p class=\"mb-auto align-items\">NO shifts!</p>
            </div>
             </div>";
          }
          ?>  

         </div>
        </div>
    </body>
</html>