<?php 
$page_title = 'Home Page';

session_start();

//if user is not logged in, redirect to index.php
if(!$_SESSION['email'] || $_SESSION['role_id']!=3){
    header('location:index.php');
}
include('autoloader.php');
$profm = new Profile();

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
        <?php
        
        echo " 
        <div class=\"jumbotron col-md-6 offset-md-3\">
            <h3>Welcome $fname!</h3>
            
        </div>
        "
        ?> 
    </body>
</html>