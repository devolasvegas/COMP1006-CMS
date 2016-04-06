<?php ob_start();
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-04-05
 * Time: 7:05 PM
 */
require_once ('auth.php');

$page_title = 'Saving Logo . . .';

require_once ('header.php');

$old_logo = $_POST['old-logo'];
$isOkay = true;

// Validate and process file upload

if (!empty($_FILES['logo']['name'])) {
    $logo = $_FILES['logo']['name'];

    $type = $_FILES['logo']['type'];

    if(($type == 'image/png') || ($type == 'image/jpeg')) {
        $final_name = session_id() . "-" . $logo;
        $tmp_name = $_FILES['logo']['tmp_name'];
        move_uploaded_file($tmp_name, "Content/Images/$final_name");
    } else {
        echo 'Your logo file must be in either JPEG or PNG format <br />';
        $isOkay = false;
    }
}

// If file validates, upload it to the server
if ($isOkay) {
    try {
        require ('db.php');
        if (!empty($old_logo)){
            $sql = "UPDATE images SET image_name = :final_name WHERE image_name = :old_logo";
        } else {
            $sql = "INSERT INTO images (image_name) VALUES (:final_name)";
        }
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':final_name', $final_name, PDO::PARAM_STR, 255);
        if (!empty($old_logo)) {
            $cmd->bindParam(':old_logo', $old_logo, PDO::PARAM_STR, 255);
        }
        $cmd->execute();

        $conn = null;

        header('location: page-logo.php');

    } catch (Exception $e) {
        mail('devondaviau@yahoo.ca', 'CMS Error', $e);
    }

}


require_once ('footer.php');

ob_flush(); ?>