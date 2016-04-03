<?php ob_start();
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-03-22
 * Time: 3:44 PM
 */
include('header.php');

// Take login form inputs and save in variables
$username = $_POST['username'];
$password = hash('sha512', $_POST['password']);

// Connect to the database
require('db.php');

// Create SQL command and bass in variable data using bound paramaters
$sql = "SELECT user_id FROM users WHERE username = :username AND password = :password";
$cmd = $conn->prepare($sql);
$cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
$cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
$cmd->execute();
// Store results of query in a variable
$users = $cmd->fetchAll();
// Store the number of rows retrieved in a variable
$count = $cmd->rowCount();

if($count == 0){
    echo 'You have entered invalid login credentials.';
    exit();
} else {
    // If user has entered valid credentials, enter the user id into $_SESSION
    foreach($users as $user){
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        header('location:user-list.php');
    }
}

$conn = null;

include('footer.php');
ob_flush(); ?>