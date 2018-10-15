<?php
$page_title = 'Rosters';

session_start();

include('autoloader.php');

$rostm = new Roster();
$account_id = $rostm -> GetAccIdbySession($_SESSION['email']);
$shifts = $rostm -> GetShiftById($account_id);

//if user is not logged in, redirect to index.php
if(!$_SESSION['email']){
    header('location:index.php');
}




?>

<!doctype html>
<html>
    <?php include('includes/head.php')?>
    <body>
        <?php include('includes/navbar.php')?>
        
        <div class="jumbotron col-md-5 offset-md-3">
            <h1 class="display-4">Rosters</h1>
            
          <?php
          if(count($shifts)>0){
          foreach ($shifts as $row){
          $shift_id = $row['shift_id'];
          $shift_date = $row['start_date'];
          $shift_time = $row['start_time'];
          $status = $row['shift_status'];
          $end_time = $row['end_time'];
          $location = $row['location'];
          $assignedby = $row['fname'];
          $assignedbylast = $row['lname'];
          $description = $row['description'];
          
          $date = date_create($shift_date);
          $time = date_create($shift_time);
          $endtime = date_create($end_time);
          

          
          $job_position = $row['job_position'];
          
          
          echo "<div class=\"row align-items-center bg-white\">
                <div class=\"col\">
                    <p class=\"mb-auto\">";echo "Date: "; echo date_format($date,"d F y"); echo "</p>
                    <p class=\"mb-auto\">";echo "Start Time: "; echo date_format($time,"h:i A"); echo"</p>
                    <p class=\"mb-auto\">"; echo ucfirst($status); echo "</p>
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
                            echo date_format($date,"D d F Y");
                            echo 
                        "</h6> <hr>
                        <h6 class=\"bold\"> Status: </h6> <p>"; echo ucfirst($status); echo "</p>"; 
                        
                        echo "<h6 class=\"bold\"> Time: </h6> <p>"; echo date_format($time,"h:i A"); echo " to "; echo date_format($endtime,"h:i A"); echo
                        "</p><h6 class=\"bold\"> Location: </h6><p>"; echo $location; 
                        echo "<h6 class=\"bold\"> Assigned by: </h6><p>"; echo $assignedby; echo " "; echo $assignedbylast; echo
                        "</p><h6 class=\"bold\"> Description: </h6><p>"; echo $description; echo
                        " </p>
                        </div>
                        <div class=\"modal-footer\">
                          <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>";
                 
              }
          } else{
             echo "<div class=\"row align-items-center bg-white\">
            <div class=\"col\">
                <p class=\"mb-auto\">NO shifts!</p>
            </div>
                 <div class=\"col-auto\">
                     <button class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#$shift_id\">View</button>
                 </div>
             </div>";
          }
          ?>  

         </div>
        </div>
    </body>
</html>