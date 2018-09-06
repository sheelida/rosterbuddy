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
            <form action="" method="post">
                <input type="text" name="username" class="username" placeholder="Username">
                <input type="password" name="password" class="password" placeholder="Password">
                <a class="passres" href="#">Forgot your password?</a>
                <button type="submit">Sign me in</button>
                <div class="error"><span>+</span></div>
            </form>
        </div>

    </body>

</html>

