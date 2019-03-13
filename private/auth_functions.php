<?php 

define("VWR", "viewer");
define("USR", "user");
define("PMT", "grader");
define("MNG", "manager");
define("ADM", "admin");
define("OWN", "owner");


function log_in($user)
{
    session_regenerate_id();
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['last_login'] = time();
    $_SESSION['user_name'] = $user['user_name'];
    // These don't happen on login, they happen on session selection/submission
    //$_SESSION[] = 
    //$_SESSION['permission'] = get_user_permissions($user['user_id']);
    return true;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        redirect_to(url_for('/index.php'));
    }
}

function require_permission($permission) {
    
}

?>