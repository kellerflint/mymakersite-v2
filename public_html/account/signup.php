<?php require_once '../../private/initialize.php' ?>
<?php 
$page_title = 'Signup';
$page_style = 'signup'; 
?>

<?php include_once '../../private/shared/default_header.php'; ?>

<div class="content">

    <h2>Create a New Account</h2>
    <form action="signup.php" method="POST">
        <label for="firstname">First Name</label>
        <br>
        <input type="text" name="firstname" id="firstname">
        <br>
        <label for="lastname">Last Name</label>
        <br>
        <input type="text" name="lastname" id="lastname">
        <br>
        <label for="username">Username</label>
        <br>
        <input type="text" name="username" id="username">
        <br>
        <label for="email">Email</label>
        <br>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password">
        <br>
        <button name="submit" id="submitBtn">Create Account</button>
    </form>

</div>

<?php include_once '../../private/shared/default_footer.php'; ?>