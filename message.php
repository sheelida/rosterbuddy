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
        <?php include('includes/navbar.php')?>
        
        <div class="jumbotron col-md-4 offset-md-4">
            <h1 class="display-4">Messages</h1>
            <div class="form-group">
                <label for="messagefrom">From:</label>
                <input class="form-control" required value="<?php echo "fname/lname";?>" type="messagefrom" name="messagefrom" id="messagefrom" readonly/>
            </div>
            <div class="form-group">
                <label for="messagedate">Date:</label>
                <input class="form-control" required value="<?php echo "01/01/2000";?>" type="messagedate" name="messagedate" id="messagedate" readonly/>
            </div>
            <div class="form-group">
                <label for="messagetext">Text:</label>
                <textarea class="form-control" rows="4" cols="50" required value="<?php echo "blub blub";?>" type="messagetext" name="messagetext" id="messagetext" readonly/>
                </textarea>
            </div>
            
            <nav aria-label="...">
                  <ul class="pagination pagination-lg">
                    <li class="page-item disabled">
                      <a class="page-link" href="#" tabindex="-1"><</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">></a></li>
                  </ul>
                </nav>
        </div>
    </body>
</html>