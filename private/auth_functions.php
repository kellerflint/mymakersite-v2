<?php 

define("VWR", "viewer");
define("USR", "user");
define("PMT", "promoter");
define("MNG", "manager");
define("ADM", "admin");
define("OWN", "owner");


function log_in($user)
{
    session_regenerate_id();
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['last_login'] = time();
    $_SESSION['user_name'] = $user['user_name'];
    //$_SESSION['user_role'] = $user['user_role'];
    return true;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

?>