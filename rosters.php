<?php
$page_title = 'Rosters';

session_start();
//if user is not logged in, redirect to login.php
if(!$_SESSION['email']){
    header('location:index.php');
}

include('autoloader.php');

$rostm = new Roster();
$account_id = $rostm -> GetAccIdbySession($_SESSION['email']);
$shifts = $rostm -> GetShiftById($account_id);

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
          $shift_date = $row['start_date'];
          $shift_time = $row['start_time'];
          $status = $row['shift_status'];
          
          echo "<div class=\"row align-items-center bg-white\">
            <div class=\"col\">
                <p class=\"mb-auto\">";echo "Date: $shift_date ";echo "- Start Time: $shift_time </p>
                <p class=\"mb-auto\">$status</p>
            </div>
                 <div class=\"col-auto\">
                     <button class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">View</button>
                 </div>
             </div>
             <hr>";
              }
          } else{
             echo "<div class=\"row align-items-center bg-white\">
            <div class=\"col\">
                <p class=\"mb-auto\">NO shifts!</p>
            </div>
                 <div class=\"col-auto\">
                     <button class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\">View</button>
                 </div>
             </div>";
          }
          ?>  

         </div>
         
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        </div>
    </body>
</html>