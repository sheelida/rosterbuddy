<?php
session_start();

include("../autoloader.php");
//check request method
if($_SERVER['REQUEST_METHOD']=='POST'){
    $response = array();
    $errors = array();
    //check the POST variables
    if($_POST['email']=='' ||$_POST['password']==''){
        $errors['empty'] = 'one of the fields is empty';
        $response['errors'] = $errors;
        $response['success'] = false;
        echo json_encode($response);
        
    }
    else{
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $account = new Account();
        $auth = $account -> authenticate ($email, $password);
        
        if($auth == true){
            //successful
            $response['success'] = true;
            $_SESSION['email'] = $email;
            
        }
        else{
            $errors['auth'] = 'Wrong credentials supplied!';
            $response['errors'] = $errors;
            $response['success'] = false;
            
    }
    
    echo json_encode($response);
}
}
?>