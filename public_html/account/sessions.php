<?php require_once '../../private/initialize.php' ?>
<?php 
$page_title = 'Sessions';
$page_style = 'sessions'; 

require_login();
?>

<?php include_once '../../private/shared/default_header.php'; ?>

<?php 
if (request_is_post()) {
    $_SESSION['permissions'] = get_session_permissions($_POST['session_id'], $_SESSION['user_id']);
    $_SESSION['session_id'] = $_POST['session_id'];

    redirect_to(url_for("/user/leaders.php"));
}
?>

<div class="content">
    <h2>My Sessions</h2>
    <?php
    $session_set = find_sessions_by_user($_SESSION['user_id']);
    
    while ($session = mysqli_fetch_assoc($session_set)) { 
        $permissions = get_session_permissions($session['session_id'], $_SESSION['user_id']);
        ?>
    <form action="sessions.php" method="POST">
        <div class="session-wrapper 
        <?php 
        if (in_array(OWN, $permissions)) {
            echo OWN;
        }
        ?>">
            <input class="hidden" name="session_id" type="text" value="<?php echo $session['session_id'] ?>">
            <p><?php echo $session['session_title']; ?></p>
            <div class="options hidden">
                <button name="submit" value="connect">Connect</button>
                <?php 
                if (in_array(OWN, $permissions)) {?>
                <button name="submit" value="delete">Delete</button>
                <?php }
                ?>

            </div>
            <br>
            <div class="descript hidden">
                <p><?php echo $session["session_description"]; ?></p>
            </div>
        </div>
    </form>

    <?php } ?>

</div>

<?php include_once '../../private/shared/default_footer.php'; ?>