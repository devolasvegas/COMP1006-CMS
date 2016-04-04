<?php
/**
 * Created by PhpStorm.
 * User: devon
 * Date: 2016-03-22
 * Time: 4:56 PM
 */
$page_title = 'Registered Users';

require('header.php');

?>

<h1>List of Registered Users</h1>

<?php

require('db.php');

$sql = "SELECT * FROM users ORDER BY user_id";

$cmd = $conn->prepare($sql);
$cmd->execute();
$users = $cmd->fetchAll();

$conn = null;

// todo Update to show fullname and email address
//todo Convert to admin panel and add link to pages admin?
echo '<table class="table table-striped">
        <thead>
            <th>User Name</th>
            <th>Full Name</th>
            <th>Email Address</th>
            <th>Edit User</th>
            <th>Delete User</th>
        </thead>
        <tbody>';

foreach($users as $user){
    echo
        '<tr>
            <td>' . $user['username'] . '</td>
            <td>' . $user['fullname'] . '</td>
            <td>' . $user['email'] . '</td>
            <td><a href="register.php?user_id=' . $user['user_id'] . '">Edit</a></td>
            <td><a class="confirmation" href="delete-user.php?user_id=' . $user['user_id'] . '">Delete</a></td>
         </tr>';
}

echo '</tbody>
      </table>';

require('footer.php');

?>