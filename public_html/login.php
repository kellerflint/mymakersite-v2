<?php require_once '../private/initialize.php' ?>

<?php 

if (request_is_post()) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = find_user_by_username($username);

    if ($user) {
        if (password_verify($password, $user['user_password'])) {
            log_in($user);
            redirect_to(url_for('/user/leaders.php'));
        } else {
            redirect_to(url_for('/index.php'));
        }
    } else {
        redirect_to(url_for('/index.php'));
    }
}

?>