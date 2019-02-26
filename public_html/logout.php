<?php require_once '../private/initialize.php' ?>

<?php 

unset($_SESSION['username']);
unset($_SESSION['user_role']);
unset($_SESSION['user_id']);


redirect_to(url_for('index.php'));

?>