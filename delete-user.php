<?php ob_start();
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-03-22
 * Time: 7:42 PM
 */
$user_id = $_GET['user_id'];

if(is_numeric($user_id)){
    require('db.php');
    
    $sql = "DELETE FROM users WHERE user_id = :user_id";
    
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $cmd->execute();
    
    $conn = null;
    
    header('location:user-list.php');
}


ob_flush(); ?>