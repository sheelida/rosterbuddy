<?php 
$page_title = 'Roster Detail';

session_start();
//if user is not logged in, redirect to login.php
if(!$_SESSION['email'] || $_SESSION['role_id']!=2){
    header('location:index.php');
}
include('autoloader.php');

//instance of Roster class
$rostm = new Roster();
//get previous page ID
$prev_id=$_GET['shift_id'];
$assto_id = $_GET['assignto_id'];

//apply get the data from DB using previous ID
$shiftdetail = $rostm -> GetShiftByShiftId($prev_id);

//setting data into a $variable
$location = $shiftdetail['location'];
$position = $shiftdetail['job_position'];
$start_time = $shiftdetail['start_time'];
$end_time = $shiftdetail['end_time'];
$status = $shiftdetail['shift_status'];
$description = $shiftdetail['description'];

//instance of Profile class
$profm = new Profile();
//applying function to get all employees 
$employees_names = $profm -> GetAllEmployees();

//transferring date to date 
/* important !*/
//data to be transferred to a datetime-local (use this example of code)
$start = date("Y-m-d\TH:i", strtotime($start_time));
$end = date("Y-m-d\TH:i", strtotime($end_time));

//if user is updating shift
if($_SERVER['REQUEST_METHOD']=='POST'){
    //handle post data
    $newlocation = $_POST['location'];
    $newposition = $_POST['position'];
    $newstart_time = date_create($_POST['start_time']);
    $newend_time = date_create($_POST['end_time']);
    $newdescription = $_POST['description'];
    $newstatus = $_POST['status'];
    $newid = $_POST['shift_id'];
    
    echo $newstart;
    echo $newend;
    
    
    
    
    $update = $rostm -> UpdateRoster($newlocation, $newposition, $newdescription, date_format($newstart_time, "Y-m-d H:i:s"), date_format( $newend_time,"Y-m-d H:i:s"), $newstatus, $newid);
    
    if($update == true){
    
        //show success message
        $message = 'The roster has been updated!';
        $message_class = 'success';
        
        header('location: employee-rosters.php');
        
    }
    
    else{
        //update failed
        $message = implode(' ', $rostm -> errors);
        $message_class = 'warning';
        //get the errors and show to user
    }
    
}
?>

<!doctype html>
<html>
    <?php include('includes/head.php')?>
    <body>
        <?php include('includes/navbar2.php')?>
        
        
        <form method="post" action="rosterdetail.php">
            <div class="jumbotron col-md-4 offset-md-4">
                <h1 class="display-4">Roster Detail</h1>
                <div class="form-group">
                <label for="employee">Assign to:</label>
                <select name="employees" required value="">
                <?php
                      if(count($employees_names)>0){
                      foreach ($employees_names as $row){
                      $emp_id= $row['acc_id'];
                      $fname = $row['fname'];
                      $lname = $row['lname'];
                    

                        $selected = ( $emp_id == $assto_id ) ? 'selected' : '';
                        echo $selected;
                        echo "<option value=\"$emp_id\" $selected >" . $fname. " ". $lname . "</option>";
                    }
                     }
                     ?>
                </select>
             
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
                <input class="form-control" type="datetime-local" required value="<?php echo $start?>" name="start_time" id="start_time"/>
            </div>
            <div class="form-group">
                <label for ="end_time">End Time: </label>
                <input class="form-control" type="datetime-local" required value="<?php echo $end;?>" name="end_time" id="end_time"/>
            </div>
            <div class="form-group">
                <label for ="description">Description: </label>
                <textarea class="form-control" type="input" name="description" id="description"><?php echo $description;?></textarea>
            </div>
        
            <div class="form-group">
                <select name="status">
                    <?php
                    $arr = array("confirmed", "pending", "cancelled");
                    
                    foreach( $arr as $option ){
                        $selected = ( $option == $status ) ? 'selected' : '';
                        echo "<option value=\"$option\" $selected >" . ucfirst($option) . "</option>";
                    }
                    ?>
                </select>
                <input type="hidden" name="shift_id" value="<?php echo $prev_id?>"/>
            </div>
                    <button name="updateRoster" class="btn btn-warning mt-1 btn-block" type="submit">Edit Roster</button>
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