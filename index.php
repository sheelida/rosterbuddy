<?php 
//include autoloader
include('autoloader.php');

$page_title = 'Sign In';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $account = new Account();
    $success = $account -> authenticate($email, $password);
    if ($success == true){
        //login successful
        session_start();
        $_SESSION['email'] = $email;
        //redirect user to homepage
        header("location: home.php");
    }
    else{
        $message = 'Wrong credentials supplied';
        $message_class = 'warning';
    }
}
?>

<!doctype html>
<html>
    <?php include('includes/head.php')?>
    <body>
        <div class="jumbotron">
            <div class="col-md-4 offset-md-4">
               <form id="signin-form" method="post" action="index.php">
                        <h3>Roster Buddy</h3>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="Insert your email address."/>
                        </div>
                        <div class="form-group">
                            <label for ="password">Password:</label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="Insert the password."/>
                            
                        </div>
                        <a href="#">Forgot your password?</a>
                        
                        
                        
                        <div class="row">
                            <button name="signin" class="btn btn-warning mt-1 btn-block" type="submit">Login</button>
                        </div>
                        
                    </form>
            
        </div>
    </body>
</html>