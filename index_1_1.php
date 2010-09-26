<?php

require_once('config.php');

$models = Doctrine_Core::loadModels('models');

$module = isset($_REQUEST['module']) ? $_REQUEST['module']:'users';
$action = isset($_REQUEST['action']) ? $_REQUEST['action']:'list';

if ($module == 'users') {
    $userId = isset($_REQUEST['id']) && $_REQUEST['id'] > 0 ? $_REQUEST['id']:null;
    $userTable = Doctrine_Core::getTable('User');

    if ($userId === null) {
        $user = new User();
    } else {
        $user = $userTable->find($userId);
    }

    switch ($action) {
        case 'edit':
        case 'add':
            echo '<form action="index.php?module=users&action=save" method="POST">
                  <fieldset>
                    <legend>User</legend>
                    <input type="hidden" name="id" value="' . $user->id . '" />
                    <label for="username">Username</label> <input type="text" name="user[username]" value="' . $user->username . '" />
                    <label for="password">Password</label> <input type="text" name="user[password]" value="' . $user->password . '" />
                    <input type="submit" name="save" value="Save" />
                  </fieldset>
                  </form>';
            break;
        case 'save':
            $user->merge($_REQUEST['user']);
            $user->save();

            header('location: index.php?module=users&action=edit&id=' . $user->id);
            break;
        case 'delete':
            $user->delete();

            header('location: index.php?module=users&action=list');
            break;
        default:
            $query = new Doctrine_Query();
            $query->from('User u')
                  ->orderby('u.username');

            $users = $query->execute();

            echo '<ul>';
            foreach ($users as $user) {
                echo '<li><a href="index.php?module=users&action=edit&id=' . $user->id . '">' . $user->username . '</a> &nbsp; <a href="index.php?module=users&action=delete&id=' . $user->id . '">[X]</a></li>';
            }
            echo '</ul>';
    }

    echo '<ul>
            <li><a href="index.php?module=users&action=add">Add</a></li>
            <li><a href="index.php?module=users&action=list">List</a></li>
          </ul>';
} else {
    throw new Exception('Invalid module');
}
