<?php ob_start();

$page_id = $_GET['page_id'];

if(is_numeric($page_id)){
    require('db.php');

    $sql = "DELETE FROM pages WHERE page_id = :page_id";

    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
    $cmd->execute();

    $conn = null;

    header('location:page-list.php');
}


ob_flush(); ?>