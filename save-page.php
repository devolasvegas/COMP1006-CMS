<?php
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-04-05
 * Time: 4:15 PM
 */

require_once ('auth.php');

$page_title = 'Saving Page . . .';

require_once ('header.php');

$pagetitle = $_POST['pagetitle'];
$pagecontent = $_POST['pagecontent'];
$page_id = $_POST['page_id'];
$edit = false;
$ok = true;

if (is_numeric($page_id)){
    $edit = true;
}

// Validate form inputs

if (empty($page_title)){
    echo 'Please give your page a title. <br />';
    $ok = false;
}

if (empty($pagecontent)){
    echo 'Please give your page some content. <br />';
    $ok = false;
}

// Process inputs if $ok

if ($ok) {
    try {
        echo 'Inside try';
        require ('db.php');
        if ($edit){
            $sql = "UPDATE pages SET pagetitle = :pagetitle, pagecontent = :pagecontent WHERE page_id = :page_id";
        } else {
            $sql = "INSERT INTO pages (pagetitle, pagecontent) VALUES (:pagetitle, :pagecontent)";
        }
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':pagetitle', $pagetitle, PDO::PARAM_STR);
        $cmd->bindParam(':pagecontent', $pagecontent, PDO::PARAM_STR);
        if ($edit){
            $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
        }
        $cmd->execute();

        $conn = null;

    } catch (Exception $e) {
        mail('devondaviau@yahoo.ca', 'CMS Error', $e);
    }

    echo 'Changes saved. Return to <a href="page-list.php" title="Go to Page List">Page List</a>';
}