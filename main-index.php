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

<!doctype html>
<html>
    <?php include('includes/head.php')?>
    
    <body>

        <div class="page-container">
            <h1>Login</h1>
            <form action="" method="post">
                <input type="text" name="username" class="username" placeholder="Username">
                <input type="password" name="password" class="password" placeholder="Password">
                <button type="submit">Sign me in</button>
            </form>
        </div>

        <!-- Javascript -->
        <script src="assets/js/jquery-1.8.2.min.js"></script>
        <script src="assets/js/supersized.3.2.7.min.js"></script>
        <script src="assets/js/supersized-init.js"></script>
        <script src="assets/js/scripts.js"></script>

        <script src="js/login.js"></script>
    </body>
</html>