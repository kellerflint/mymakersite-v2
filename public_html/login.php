<?php require_once '../private/initialize.php' ?>

<?php 

if (request_is_post()) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = find_user($username);

    if ($user) {
        if (password_verify($password, $user['user_password'])) {
            log_in($user);
            redirect_to(url_for('/student/index.php'));
        } else {
            echo "Login was unsuccessful.";
        }
    } else {
        echo "Login was unsuccessful.";
    }
}

?>