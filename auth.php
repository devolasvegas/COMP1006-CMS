<?php
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-03-16
 * Time: 11:48 AM
 */

session_start();

if (empty($_SESSION('user-id'))){
    header('location:login.php');
    exit();
}