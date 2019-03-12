<?php require_once '../../private/initialize.php' ?>
<?php 
$page_title = 'Account';
$page_style = 'account'; 
?>

<?php include_once '../../private/shared/default_header.php'; ?>

<?php 

$user = find_user_by_id($_SESSION['user_id']);

if(request_is_post()) {
    
    $user['user_name'] = hsc($_POST['username']);
    $user['user_first'] = hsc($_POST['firstname']);
    $user['user_last'] = hsc($_POST['lastname']);
    $user['user_email'] = hsc($_POST['email']);
    
    $result = edit_user($user, $_SESSION['user_id']);

    if ($result !== true) {
        $errors = $result;
    }
} 
?>

<div class="content">

    <h2>Edit Account</h2>

    <?php echo display_errors($errors); ?>

    <form action="account.php" method="POST">
        <label for="firstname">First Name</label>
        <br>
        <input type="text" name="firstname" id="firstname" value="<?php echo $user['user_first']; ?>">
        <br>
        <label for="lastname">Last Name</label>
        <br>
        <input type="text" name="lastname" id="lastname" value="<?php echo $user['user_last']; ?>">
        <br>
        <label for="username">Username</label>
        <br>
        <input type="text" name="username" id="username" value="<?php echo $user['user_name']; ?>">
        <br>
        <label for="email">Email</label>
        <br>
        <input type="text" name="email" id="email" value="<?php echo $user['user_email']; ?>">
        <br>
        <button name="submit" id="submitBtn">Submit</button>
    </form>

</div>

<?php include_once '../../private/shared/default_footer.php'; ?>