<?php

session_start();

if (empty($_SESSION('user-id'))){
    header('location:login.php');
    exit();
}