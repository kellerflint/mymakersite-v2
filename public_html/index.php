<?php require_once '../private/initialize.php' ?>
<?php 
$page_title = 'Login';
$page_style = 'login'; 
?>

<?php include_once '../private/shared/default_header.php'; ?>

<?php 
if (request_is_post()) {

    if ($_POST['submit'] == "new-account") {
        redirect_to(url_for('/account/signup.php'));
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = find_user_by_username($username);

    if ($user) {
        if (password_verify($password, $user['user_password'])) {
            log_in($user);
            redirect_to(url_for('/account/sessions.php'));
        } else {
            $errors[] = "Login failed. Invalid username or password.";
        }
    } else {
        $errors[] = "Login failed. Invalid username or password.";
    }
}
?>

<div class="content">
    <h2>Login to MyMakerSite</h2>
    <?php echo display_errors($errors); ?>
    <form action="index.php" method="POST">
        <label for="username">Username</label>
        <br>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password">
        <br>
        <button name="submit" id="submitBtn" value="login">Login</button>
        <br>
        <h3>OR</h3>
        <br>
        <button name="submit" value="new-account">
            Create a New Account
        </button>
    </form>
</div>



<?php include_once '../private/shared/default_footer.php'; ?>