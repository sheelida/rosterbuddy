<?php
$page_title = 'New Shift';

session_start();
//if user is not logged in, redirect to login.php
if(!$_SESSION['email']){
    header('location:index.php');
}

include('autoloader.php');


$rostm = new Roster();


$account_id = $rostm -> GetAccIdbySession($_SESSION['email']);
$shifts = $rostm -> GetShiftsAssignedBy($account_id);

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
    
    
    $newshift = $rostm -> InsertNewShift($newlocation, $newposition, $newdescription, date_format($newstart_time, "Y-m-d H:i:s"), date_format( $newend_time,"Y-m-d H:i:s"), $newstatus, $account_id);
    
    if($newshift == true){
    
        //show success message
        $message = 'The shift has been added!';
        $message_class = 'success';
        
        header('location: shome.php');
        
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
        <form method="post" action="newshift.php">
        <div class="jumbotron col-md-4 offset-md-4">
            <h1 class=\"display-4\">New Shift</h1>
             <div class="form-group">
                <label for="location">Location:</label>
                <input class="form-control" required value="" type="text" name="location" id="location"/>
            </div>
             <div class="form-group">
                <label for="position">Job position:</label>
                <input class="form-control" required value="" type="text" name="position" id="position"/>
            </div>
     
            <div class="form-group">
                <label for ="start_time">Start date:</label>
                <input class="form-control" type="datetime-local" required value="" name="start_time" id="start_time"/>
            </div>
            <div class="form-group">
                <label for ="end_time">End date:</label>
                <input class="form-control" type="datetime-local" required value="" name="end_time" id="end_time"/>
            </div>
            <div class="form-group">
                <label for ="description">Description: </label>
                <textarea class="form-control" type="input" name="description" id="description"></textarea>
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
            </div>
                <button name="newshift" class="btn btn-warning mt-1 btn-block" type="submit">Submit Shift</button>
        
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