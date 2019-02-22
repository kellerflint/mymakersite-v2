<?php 

function log_in($user)
{
    session_regenerate_id();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $user['user_name'];

    return true;
}

?>