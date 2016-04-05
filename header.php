<?php

// Retrieve any page info from the database
try {
    require ('db.php');
    $sql = "SELECT page_id, pagetitle FROM pages";
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $count = $cmd->rowCount();
    $pages = $cmd->fetchAll();

    $conn = null;
} catch (Exception $e){
    mail('devondaviau@yahoo.ca', 'CMS Error', $e);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $page_title; ?></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
</head>
<body>
    <nav class="navbar navbar-default">

    <a href="default.php" title="Home" class="navbar-brand"><i class=""></i>  Devon's CMS</a>

    <ul class="nav navbar-nav pull-right">
        <li><a href="default.php" title="Home">Home</a></li>
        <!-- If there are pages in the database, add them to the navigation -->
        <?php
        if ($count > 0){
            foreach ($pages as $page) {
                echo '<li><a href="default.php?page_id=' . $page['page_id'] . '">' . $page['pagetitle'] . '</a></li>';
            }
        }
        // If the page is being accessed by a registered user, display the appropriate links
        session_start();
        if (!empty($_SESSION['user_id'])) {
            echo '<li><a href="page-list.php" title="Page Administration">Pages</a></li>
                  <li><a href="user-list.php" title="User Administration">Users</a></li>';
        } else {
            echo '<li><a href="register.php" title="Register">Sign Up</a></li>
                  <li><a href="login.php" title="Log In">Sign In</a></li>';
        }
        ?>
    </ul>

    </nav>

    <main>