<?php 
$page_title = 'Profile';

session_start();
//if user is not logged in, redirect to login.php
if(!$_SESSION['email']){
    header('location:index.php');
}
include('autoloader.php');

$profm = new Profile();

//if user is updating account
if($_SERVER['REQUEST_METHOD']=='POST'){
    //handle post data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password = $_POST['password'];
    
    $update = $profm -> UpdateProfile($fname,$lname,$_SESSION['email'],$password);
    
    
    if($update == true){
        //update succeded
        //start the session
        session_start();
    
        //show success message
        $message = 'Your account has been updated!';
        $message_class = 'success';
        
    }
    
    else{
        //update failed
        $message = implode(' ',$profile -> errors);
        $message_class = 'warning';
        //get the errors and show to user
    }
    
}

$account_data = $profm -> getData($_SESSION['email']);


$fname = $account_data['fname'];
$lname = $account_data['lname'];
$email = $account_data['email'];

?>

<!doctype html>
<html>
    <?php include('includes/head.php')?>
    <body>
        <?php include('includes/navbar.php')?>
        <form method="post" action="profile.php">
            <div class="jumbotron col-md-4 offset-md-4">
                <h1 class="display-4">Profile</h1>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input class="form-control" required value="<?php echo $email;?>" type="email" name="email" id="email" readonly/>
            </div>
            
            <div class="form-group">
                <label for="fname">First Name: </label>
                <input class="form-control" required value="<?php echo $fname;?>" type="text" name="fname" id="fname"/>
            </div>
            <div class="form-group">
                <label for="lname">Last Name: </label>
                <input class="form-control" required value="<?php echo $lname;?>" type="text" name="lname" id="lname"/>
            </div>
            <div class="form-group">
                <label for ="password">Password: </label>
                <input class="form-control" type="password" name="password" id="password" placeholder="Insert the password."/>
            </div>
                    <button name="update" class="btn btn-warning mt-1 btn-block" type="submit">Update Info</button>
            </div>
        </form>


    </body>
</html>