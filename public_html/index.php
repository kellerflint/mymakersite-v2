<?php require_once '../private/initialize.php' ?>
<?php 
$page_title = 'Login';
$page_style = 'login'; 
?>

<?php include_once '../private/shared/default_header.php'; ?>

<div class="content">
    <h2>Login to MyMakerSite</h2>
    <form action="login.php" method="POST">
        <label for="username">Username</label>
        <br>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password">
        <br>
        <button name="submit" id="submitBtn">Login</button>
        <br>
        <h3>OR</h3>
        <br>
        <button id="new-account">
            <a href="<?php echo url_for('/account/signup.php'); ?>">Create a New Account</a>
        </button>
    </form>
</div>



<?php include_once '../private/shared/default_footer.php'; ?>