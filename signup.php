<?php
//include autoloader
include('autoloader.php');

$page_title = 'Register Employee';

//check request method
//if request is a POST request
if($_SERVER['REQUEST_METHOD']=='POST'){
    //handle sign up here
    $account = new Account();
    //receive post variables from form
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    //sign user up 
    $signup = $account -> create($fname,$lname,$email,$password);
    if($signup == true){
        //signup succeded
        //start the session
        session_start();
        
        //create session variable with user's email
        $_SESSION['email'] = $email;
        //show success message
        $message = 'Your account has been created!';
        $message_class = 'success';
        
    }
    
    else{
        //signup failed
        $message = implode(' ',$account -> errors);
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
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <form id="signup-form" method="post" action="signup.php">
                        <h3>Register a New Employee</h3>
                         <div class="form-group">
                            <label for="fname">First Name:</label>
                            <input class="form-control" type="fname" name="fname" id="fname" placeholder="E.g Josias"/>
                        </div>
                         <div class="form-group">
                            <label for="lname">Last Name:</label>
                            <input class="form-control" type="lname" name="lname" id="lname" placeholder="Bittencourt"/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="you@example.com"/>
                        </div>
                        <div class="form-group">
                            <label for ="password">Password</label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="minimum 6 characters"/>
                            
                        </div>
                        
                        <button class="btn btn-warning mt-2" type="reset">Clear</button>
                        <button class="btn btn-info mt-2" type="submit">Sign up</button>
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
                    
                </div>
            </div>
        </div>
    </body>
</html>
