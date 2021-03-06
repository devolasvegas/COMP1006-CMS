<?php
session_start();
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

require ('image-retrieve.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php
        // Insert page title from db if page_id is in url
        if(is_numeric($page_id)){
        echo $pages[$page_id-1]['pagetitle'];
        } else {
            echo $page_title;
        } ?></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="Content/css/styles.css" />
</head>
<body>
    <nav class="navbar navbar-default">
    <div class="container">
    <a href="default.php" title="Home" class="navbar-brand">
        <?php if (!empty($logo)) {
            echo '<img src="Content/images/' . $logo . '" alt="Site Logo" height="50" width="50" />';
        } else {
            echo
            '<i class="fa fa-magic"></i>';
        }
        ?>  Widgets Inc.</a>

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

        if (!empty($_SESSION['user_id'])) {
            echo '<li><a href="page-list.php" title="Page Administration">Pages</a></li>
                  <li><a href="user-list.php" title="User Administration">Users</a></li>
                  <li><a href="page-logo.php" title="Upload Page Logo">Page Logo</a> </li>
                  <li><a href="logout.php" title="Log Out">Sign Out</a></li>';
        } else {
            echo '<li><a href="register.php" title="Register">Sign Up</a></li>
                  <li><a href="login.php" title="Log In">Sign In</a></li>';
        }
        ?>
    </ul>
    </div> <!-- Container -->

    </nav>

    <main>