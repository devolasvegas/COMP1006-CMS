<?php

try {
require ('db.php');
$sql = "SELECT * FROM images";
$cmd = $conn->prepare($sql);
$cmd->execute();
$image_count = $cmd->rowCount();

$conn = null;

if ($image_count > 0){
    $logo = $cmd->fetch()['image_name'];
}

} catch (Exception $e){
    mail('devondaviau@yahoo.ca', 'CMS Error', $e);
}

?>