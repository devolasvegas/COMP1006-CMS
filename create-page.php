<?php ob_start();
session_start();

require ('auth.php');

/**
 * Created by PhpStorm.
 * page: devon
 * Date: 2016-03-19
 * Time: 11:44 PM
 */
if(is_numeric($_GET['page_id'])){
    $page_title = "Edit Web Page";
} else {
$page_title = 'Create New Web Page';
}

require('header.php');


// Execute if the page_id is being passed from the page-list page
if(is_numeric($_GET['page_id'])){

    $page_id = $_GET['page_id'];
    try {
        require_once('db.php');

        $sql = "SELECT * FROM pages WHERE page_id = :page_id";
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
        $cmd->execute();
        $pages = $cmd->fetchAll();

        $conn = null;
    } catch (Exception $e) {
        mail('devondaviau@yahoo.ca', 'CMS Error' $e)
}

    foreach($pages as $page){
        $page_id = $page['page_id'];
        $pagetitle = $page['pagetitle'];
        $pagecontent = $page['pagecontent'];
    }

    echo '<h1>Edit Page Info</h1>';
} else {
    echo " <h1>Create a New Page</h1>";
}
?>


<form method="post" action="save-page.php" class="form-horizontal">
    <div class="form-group">
        <label for="pagetitle" class="col-sm-2">Page Title</label>
        <input name="pagetitle" id="pagetitle" value="<?php echo $pagetitle; ?>"/>
    </div>
    <div class="form-group">
        <label for="pagecontent" class="col-sm-2">Page Content</label>
        <textarea name="pagecontent" id="pagecontent" rows="6" ><?php echo $pagecontent; ?></textarea>
    </div>
    <div class="col-sm-offset-2">
        <input type="submit" value="Submit Form" class="btn" />
    </div>
    <input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id; ?>" />
</form>

<?php

require('footer.php'); 

ob_flush(); ?>
