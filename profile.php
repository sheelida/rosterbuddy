<?php 
$page_title = 'Profile';
?>

<!doctype html>
<html>
    <?php include('includes/head.php')?>
    <body>
        <?php include('includes/navbar.php')?>
        
        <div class="jumbotron col-md-4 offset-md-4">
            <h1 class="display-4">Profile</h1>
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input class="form-control" type="email" name="email" id="email"/>
        </div>
        
        <div class="form-group">
            <label for="fname">First Name: </label>
            <input class="form-control" type="text" name="fname" id="fname"/>
        </div>
        <div class="form-group">
            <label for="lname">Last Name: </label>
            <input class="form-control" type="text" name="lname" id="lname"/>
        </div>
        <div class="form-group">
            <label for ="password">Password: </label>
            <input class="form-control" type="password" name="password" id="password" placeholder="Insert the password."/>
        </div>
                <button name="update" class="btn btn-warning mt-1 btn-block" type="submit">Update Info</button>
        </div>



    </body>
</html>