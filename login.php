<?php

/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-03-22
 * Time: 3:35 PM
 */

$page_title = 'Log In';

require_once('header.php');

?>

<h1>User Log In</h1>

<form action="validate.php" method="post" class="form-horizontal">
    <div class="form-group">
        <label for="username" class="col-sm-2">User Name</label>
        <input name="username" id="username"/>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2">Password</label>
        <input type="password" name="password" id="password"/>
    </div>
    <div class="col-sm-offset-2">
        <input type="submit" value="Submit" class="btn">
    </div>

<?php
require_once('footer.php');

?>
