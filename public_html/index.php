<?php require_once '../private/initialize.php' ?>

<?php $page_title = 'Home' ?>

<?php include_once '../private/shared/default_header.php'; ?>

<div class="content">
    <form action="login.php" method="POST">
        <label for="username">username</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">password</label>
        <input type="text" name="password" id="password">
        <br>
        <button name="submit">Login</button>
    </form>
</div>

<?php include_once '../private/shared/default_footer.php'; ?>