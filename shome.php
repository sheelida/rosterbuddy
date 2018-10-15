<?php 
$page_title = 'Home Page';

session_start();

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
        <?php include('includes/navbar2.php')?>
        <?php
        
        echo " 
        <div class=\"jumbotron col-md-6 offset-md-3\">
            <h3>Welcome $fname!</h3>
            
        </div>
        "
        ?>




    </body>
</html>