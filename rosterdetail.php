<?php 
$page_title = 'Roster Detail';

session_start();
//if user is not logged in, redirect to login.php
if(!$_SESSION['email']){
    header('location:index.php');
}
include('autoloader.php');

$rostm = new Roster();
$prev_id=$_GET['shift_id'];
$shiftdetail = $rostm -> GetShiftByShiftId($prev_id);

$location = $shiftdetail['location'];
$position = $shiftdetail['job_position'];
$start_time = $shiftdetail['start_time'];
$end_time = $shiftdetail['end_time'];
$status = $shiftdetail['shift_status'];

$profm = new Profile();
$employees_names = $profm -> GetAllEmployees();

?>

<!doctype html>
<html>
    <?php include('includes/head.php')?>
    <body>
        <?php include('includes/navbar2.php')?>
        
        
        <form method="post" action="profile.php">
            <div class="jumbotron col-md-4 offset-md-4">
                <h1 class="display-4">Roster Detail</h1>
                <?php
                 echo "<div class=\"form-group\">
                <select name=\"status\" required value=\"\">";
                      if(count($employees_names)>0){
                      foreach ($employees_names as $row){
                      $emp_id= $row['acc_id'];
                      $fname = $row['fname'];
                      $lname = $row['lname'];
                      
                      echo "
                      <option value=\"$emp_id\">$fname $lname</option>";
                      }
                     }
                echo "</select>";
                ?>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input class="form-control" required value="<?php echo $location;?>" type="text" name="location" id="location"/>
            </div>
            
            <div class="form-group">
                <label for="position">Job Position: </label>
                <input class="form-control" required value="<?php echo $position;?>" type="text" name="position" id="position"/>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time: </label>
                <input class="form-control" type="datetime-local" required value="<?php echo $start_time;?>" name="start_time" id="start_time"/>
            </div>
            <div class="form-group">
                <label for ="end_time">End Time: </label>
                <input class="form-control" type="datetime-local" required value="<?php echo $end_time;?>"name="end_time" id="end_time"/>
            </div>
            <div class="form-group">
                <select name="status" required value="<?php echo $status?>">
                      <option value="confirmed">Confirmed</option>
                      <option value="pending">Pending</option>
                      <option value="cancelled">Cancelled</option>
                </select>
            </div>
                    <button name="update" class="btn btn-warning mt-1 btn-block" type="submit">Assign Roster</button>
            </div>
        </form>
                <?php
                    if($message){
                        echo "<div class=\"alert alert-$message_class alert-dismissable fade show\">
                            $message
                            <button class=\" close\" type=\"button\" data-dismiss=\"alert\">
                            &times;
                            </button>
                        </div>";
                }
                ?>
    </body>
</html>