<?php ob_start();

session_start();

require ('auth.php');
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-04-04
 * Time: 11:35 AM
 */

require ('header.php');

try {
    require_once('db.php');

    $sql = "SELECT * FROM pages";
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $pages = $cmd->fetchAll();

    $conn = null;

} catch (Exception $e) {
    mail('devondaviau@yahoo.ca', 'CMS Error', $e);
    header('location: error.php');
}

echo '<table class="table table-striped">
        <thead>
        <th>Page Title</th>
        <th>Edit Page</th>
        <th>Delete Page</th>
      </thead>
      <tbody>';

foreach ($pages as $page){
    echo '<tr>
            <td>' . $page['pagetitle'] . '</td>
            <td><a href="add-page.php?page_id=' . $page['page_id'] . '"</td>
            <td><a href="delete-page?page_id=' . $page['page_id'] . '"</td>
          </tr>';
}

echo '</tbody>
      </table>';



require ('footer.php');

ob_flush(); ?>