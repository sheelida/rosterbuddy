<?php
$page_title = 'Messages';

session_start();
//if user is not logged in, redirect to login.php
if(!$_SESSION['email']){
    header('location:index.php');
}

include('autoloader.php');

$rostm = new Roster();
$account_id = $rostm -> GetAccIdbySession($_SESSION['email']);
$messages = $rostm -> GetMessageById($account_id);
//instance of Profile class
$profm = new Profile();
//applying function to get all employees 
$employees_names = $profm -> GetAllEmployees();

//if user is updating account
if($_SERVER['REQUEST_METHOD']=='POST'){
    //handle post data
    $message = $_POST['message'];
    $recipient = $_POST['employees'];
    
    $sendmsg = $rostm -> InsertNewMessage($message,$recipient, $account_id);
    
    
    if($sendmsg == true){
        //insert succeded
        //start the session
        session_start();
    
        //show success message
        $message = 'Your message has been sent!';
        $message_class = 'success';
        
        header('location: shome.php');
        
    }
    
    else{
        //insert failed
        $message = implode(' ',$rostm -> errors);
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
        <form method="post" action="smessage.php">
        <div class="jumbotron col-md-4 offset-md-4">
            <h1 class=\"display-4\">Messages</h1>
            <div class="form-group">
                <label for="employee">Recipient: </label>
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
                <label for ="message">Message: </label>
                <textarea class="form-control" type="input" name="message" id="message"></textarea>
            </div>
            <button name="send" class="btn btn-warning mt-1 btn-block" type="submit">Send Message</button>
            
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