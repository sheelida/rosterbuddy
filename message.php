<?php
$page_title = 'Messages';

session_start();
//if user is not logged in, redirect to login.php
if(!$_SESSION['email']){
    header('location:index.php');
}

include('autoloader.php');

$rostm = new Roster();
$account_id = $rostm -> GetAccIdbySession($_SESSION['email']);
$messages = $rostm -> GetMessageById($account_id);
?>

<!doctype html>
<html>
    <?php include('includes/head.php')?>
    <body>
        <?php include('includes/navbar2.php')?>
        <div class="jumbotron col-md-4 offset-md-4">
            <h1 class=\"display-4\">Messages</h1>
        <?php
        if(count($messages)>0){
            foreach($messages as $row){
                $message_id = $row['message_id'];
                $message_desc = $row['message_desc'];
                $message_date = $row['message_date']; 
                $message_sender = $row['sender_name'];
                
                $date = date_create($message_date);
                
                echo "
                
                <div class=\"accordion\" id=\"accordionExample\">
                  <div class=\"card\">
                    <div class=\"card-header\" id=\"headingOne\">
                      <h5 class=\"mb-0\">
                        <button class=\"btn btn-link\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapse$message_id\" aria-expanded=\"true\" aria-controls=\"collapseOne\">
                         <p> From: "; echo $message_sender; echo " </p>
                         <p> Date: "; echo date_format($date,"d F y"); echo "</p>
                        </button>
                      </h5>
                    </div>
                    <div id=\"collapse$message_id\" class=\"collapse show\" aria-labelledby=\"headingOne\" data-parent=\"#accordionExample\">
                      <div class=\"card-body\">";
                      echo $message_desc; echo "
                    </div>
            </div>";
            }

        } else{
                echo "<div class=\"row align-items-center bg-white\">
                        <div class=\"col\">
                            <p class=\"mb-auto\">NO messages available!</p>
                        </div>
                    <div class=\"col-auto\">
                        <button class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#$shift_id\">View</button>
                    </div>
             </div>";
            }
            ?>
            </div>
    </body>
</html>