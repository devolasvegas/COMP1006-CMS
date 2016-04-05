<?php ob_start();
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-04-05
 * Time: 2:14 PM
 */

session_start();

session_unset();

session_destroy();

header('location:logged-out.php');

ob_flush(); ?>