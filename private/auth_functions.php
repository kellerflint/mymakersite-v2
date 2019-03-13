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

// Redirects to sessions if permissions are invalid, redirects to login if not logged in
// @param permission title required
function require_permission($required) {
    require_login();
    if (!in_array($required, $_SESSION['permissions'])) {
        redirect_to(url_for("/account/sessions.php"));
    }
}

?>