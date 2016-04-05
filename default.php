<?php
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-04-03
 * Time: 11:53 PM
 */
if (is_numeric($_GET['page_id'])){
    $page_id = $_GET['page_id'];
    require ('db.php');
    $sql = "SELECT * FROM pages WHERE page_id = :page_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
    $cmd->execute();
    $data = $cmd->fetchAll();
    $conn = null;

} else {
    $page_title = 'Home | Web Page';
}

require ('header.php');

if (is_numeric($page_id)){
    foreach ($data as $datum){
    echo '<h1>' . $datum['pagetitle'] . '</h1>
          <p>' . $datum['pagecontent'] . '</p>';
    }
} else {

echo

'<div class="jumbotron">
    <h1>Welcome to Widgets Inc.</h1>
    <p>Thank you for visiting our page and viewing our great selection of widgets.</p>
</div>';

}



require ('footer.php');

?>
