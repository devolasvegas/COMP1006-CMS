<?php ob_start();


require ('auth.php');
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-04-04
 * Time: 11:35 AM
 */

$page_title = 'Page List';

require ('header.php');

try {

    require ('db.php');

    $sql = "SELECT * FROM pages";
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $pages = $cmd->fetchAll();

    $conn = null;
} catch (Exception $e) {
    mail('devondaviau@yahoo.ca', 'CMS Error', $e);
    header('location: error.php');
}


echo '<h1>Page List</h1>

    <button class="btn btn-default"><a href="create-page.php" title="Create a New Web Page">Create a New Web Page</a></button>

    <table class="table table-striped">
    <thead>
        <th>Page Title</th>
        <th>Edit Page</th>
        <th>Delete Page</th>
    </thead>
    <tbody>';

foreach ($pages as $page){
    echo '<tr>
            <td>' . $page['pagetitle'] . '</td>
            <td><a href="create-page.php?page_id=' . $page['page_id'] . '" title="Edit Page">Edit</a></td>
            <td><a class="confirmation-page" href="delete-page.php?page_id=' . $page['page_id'] . '" title="Delete Page">Delete</a></td>
          </tr>';
}

echo '</tbody>
      </table>';



require ('footer.php');

ob_flush(); ?>