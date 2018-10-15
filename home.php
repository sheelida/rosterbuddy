<?php 
$page_title = 'Home Page';

session_start();

//if user is not logged in, redirect to index.php
if(!$_SESSION['email'] || $_SESSION['role_id']!=3){
    header('location:index.php');
}
?>

<!doctype html>
<html>
    <?php include('includes/head.php')?>
    
    <body>
     
    </body>
</html>