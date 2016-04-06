<?php
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-04-05
 * Time: 7:00 PM
 */

require_once('auth.php');

$page_title = "Upload Page Logo";

require_once('header.php');

// Retrieve logo from db if exists
try{
    require ('db.php');
    $sql = "SELECT * FROM images";
    $cmd = $conn->prepare($sql);
    $cmd->execute();
    $count = $cmd->rowCount();
    $logo = $cmd->fetchAll();
    $conn = null;
    if ($count > 0) {
        foreach ($logo as $item) {
            $old_logo_id = $item['image_id'];
            $old_logo_name = $item['image_name'];
        }
    }
    
} catch (Exception $e) {
    mail('devondaviau@yahoo.ca', 'CMS Error', $e);
}
?>

    <h1>Upload a Page Header Logo</h1>
    
    <p>Choose an image from your computer to appear in the header on every page.</p>
    
    <form method="post" action="save-logo.php" enctype="multipart/form-data">
        <input type="file" name="logo" required />
        <?php
        if(!empty($logo)) {
            echo
                '<div class="col-sm-offset-2">
			        <img class="img" title="logo" src="Content/images/' . $old_logo_name . '" />
		        </div>';
        } ?>
        <input type="hidden" name="old-logo" id="old-logo" value="<?php echo $old_logo_id; ?>" />
        <button class="btn btn-primary col-sm-offset-2">Upload</button>
    </form>

<?php

require_once('footer.php');

?>