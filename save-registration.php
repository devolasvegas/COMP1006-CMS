<?php ob_start();
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-03-22
 * Time: 11:26 AM
 */

$page_title = 'Saving your registration . . .';
require_once ('header.php');

// Put form inputs into variables
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$user_id = $_POST['user_id'];
$confirm = $_POST['confirm'];
$edit = false;
$ok = true;

// If a user id was passed in the $_POST array, set the $edit flag to true
if (is_numeric($user_id)) {
    $edit = true;
}

// Validate inputs
// If there is no user id being passed, screen for duplicate user names
//if (!$edit) {
try {
// Connect to the database and fetch usernames to screen for duplicates
    require('db.php');

    $sql = "SELECT username, user_id FROM users WHERE username = :username";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
//    $cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $cmd->execute();
    $users = $cmd->fetchAll();
    $count = $cmd->rowCount();

    $conn = null;

    foreach ($users as $user) {
        $name = $user['username'];
        $id = $user['user_id'];
        if ($username == $name && $user_id != $id) {
            echo 'That username already exists';
            $ok = false;
        }
    }
} catch (Exception $e) {
    mail('devondaviau@yahoo.ca', 'CMS Error', $e);
    header('location:error.php');
}



if (empty($email)) {
    echo 'Email address is required<br />';
    $ok = false;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Please enter a valid email address<br />';
    $ok = false;
}

if (empty($fullname)) {
    echo 'Please supply your full name<br />';
    $ok = false;
}

if (empty($password)) {
    echo 'Password is required<br />';
    $ok = false;
}

if ($password != $confirm) {
    echo 'Passwords must match<br />';
    $ok = false;
}

// Save registration if form validates

if ($ok) {
    try {

        // Connect to the DB
        require('db.php');
        if ($edit) {
            $sql = "UPDATE users SET fullname = :fullname, email = :email, username = :username, password = :password WHERE user_id = :user_id";
        } else {
            $sql = "INSERT INTO users (fullname, email, username, password) VALUES (:fullname, :email, :username, :password)";
        }
        // Hash the password
        $hashed_password = hash('sha512', $password);

        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':fullname', $fullname, PDO::PARAM_STR, 50);
        $cmd->bindParam(':email', $email, PDO::PARAM_STR, 50);
        $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
        $cmd->bindParam(':password', $hashed_password, PDO::PARAM_STR, 128);
        if ($edit) {
            $cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        }
        $cmd->execute();

        // Disconnect from DB
        $conn = null;

        if ($edit) {
            echo 'Changes saved. Return to <a href="user-list.php" title="User List">User List</a>';
        } else {
            echo 'Your registration has been accepted. Click to <a href="login.php" title="Log In">Login</a>';
        }

    } catch (Exception $e) {
        mail('devondaviau@yahoo.ca', 'CMS Error', $e);
        header('location:error.php');
    }
}

require('footer.php');

ob_flush(); ?>