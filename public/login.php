<?php require_once '../private/initialize.php' ?>

<?php 

if (request_is_post()) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $_SESSION['username'] = $username;

    redirect_to(url_for('/student/index.php'));
}

?>