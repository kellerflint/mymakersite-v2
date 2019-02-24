<?php 

define("STU", "student");
define("INS", "instructor");
define("ADM", "admin");


function log_in($user)
{
    session_regenerate_id();
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $user['user_name'];
    $_SESSION['user_role'] = $user['user_role'];
    return true;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_role($role) {
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == STU) {
            if ($role == STU) {
                return true;
            } else {
                redirect_to(url_for('/index.php'));
            }
        } else if ($_SESSION['user_role'] == INS) {
            if ($role == INS || $role == STU) {
                return true;
            } else {
                redirect_to(url_for('/index.php'));
            }
        } else if ($_SESSION['user_role'] == ADM) {
            if ($role == ADM || $role == INS || $role == STU) {
                return true;
            } else {
                redirect_to(url_for('/index.php'));
            }
        } else {
            redirect_to(url_for('/index.php'));
        }
    } else {
        redirect_to(url_for('/index.php'));
    }
}
function check_role_access($role) {
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == STU) {
            if ($role == STU) {
                return true;
            } else {
                return false;
            }
        } else if ($_SESSION['user_role'] == INS) {
            if ($role == INS || $role == STU) {
                return true;
            } else {
                return false;
            }
        } else if ($_SESSION['user_role'] == ADM) {
            if ($role == ADM || $role == INS || $role == STU) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

?>