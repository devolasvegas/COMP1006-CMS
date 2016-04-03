<?php

/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-03-19
 * Time: 11:44 PM
 */

$page_title = 'Sign Up';

require('header.php');


// Execute if the user_id is being passed from the user-list page
if(is_numeric($_GET['user_id'])){

    $user_id = $_GET['user_id'];

    require('db.php');

    $sql = "SELECT * FROM users WHERE user_id = :user_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $cmd->execute();
    $users = $cmd->fetchAll();

    $conn = null;

    foreach($users as $user){
        $fullname = $user['fullname'];
        $email = $user['email'];
        $username = $user['username'];
        $password = $user['password'];
    }
}
?>

    <h1>Register a New User</h1>
    
    <!--todo Add Full name, email address -->
    <form method="post" action="save-registration.php" class="form-horizontal">
        <div class="form-group">
            <label for="fullname" class="col-sm-2">Full Name</label>
            <input name="fullname" id="fullname" value="<?php echo $fullname; ?>"/>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2">Email Address</label>
            <input type="email" name="email" id="email" value="<?php echo $email; ?>" />
        </div>
        <div class="form-group">
            <label for="username" class="col-sm-2">User Name</label>
            <input name="username" id="username" value="<?php echo $username; ?>"/>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2">Password</label>
            <input type="password" name="password" id="password" value="<?php echo $password; ?>" />
        </div>
        <div class="form-group">
            <label for="confirm" class="col-sm-2">Confirm Password</label>
            <input type="password" name="confirm" id="confirm"/>
        </div>
        <div class="col-sm-offset-2">
            <input type="submit" value="Submit Form" class="btn" />
        </div>
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
    </form>

<?php

require('footer.php'); ?>
