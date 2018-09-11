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
        $message = 'Wrong credentials supplied!';
        $message_class = 'warning';
    }
}
?>


<!DOCTYPE html>
<html lang="en" class="no-js">
    <?php include('includes/head2.php')?>
    
            <!-- Javascript -->
        <script src="js/script4.js"></script>
        <script src="js/script3.js"></script>
        <script src="js/script2.js"></script>
        <script src="js/script1.js"></script>
        
    <body>

        <div class="page-container">
            <div class="logo"></div>
            <div class="form-group">
            <form id="signin-form" action="index.php" method="post">
                <input class="form-control" type="email" name="email" placeholder="Email Address">
                <input class="form-control" type="password" name="password" placeholder="Password">
                <a href="#">Forgot your password?</a>
                <button name="signin" type="submit">Sign me in</button>
                <div class="error"><span>+</span></div>
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
        <script src="js/login.js"></script>
    </body>

</html>