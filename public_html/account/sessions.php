<?php require_once '../../private/initialize.php' ?>
<?php 
$page_title = 'Sessions';
$page_style = 'sessions'; 

require_login();
?>

<?php include_once '../../private/shared/default_header.php'; ?>

<?php 
if (request_is_post()) {
    
}
?>

<div class="content">
    <h2>My Sessions</h2>
    <form action="sessions.php" method="POST">
        <?php
    $session_set = find_sessions_by_user($_SESSION['user_id']);
    
    while ($session = mysqli_fetch_assoc($session_set)) { 
        $permission_set = get_session_permissions($session['session_id'], $_SESSION['user_id']);
        ?>

        <div class="session-wrapper 
        <?php 
        if (in_data_set($permission_set, "permission_title", OWN)) {
            echo OWN;
        }
        ?>">
            <input class="hidden" name="session_id" type="text" value="<?php echo $session['session_id'] ?>">
            <p><?php echo $session['session_title']; ?></p>
            <div class="options hidden">
                <button name="submit hidden" value="connect">Connect</button>
            </div>
            <br>
            <div class="descript hidden">
                <p><?php echo $session["session_description"]; ?></p>
            </div>
        </div>

        <?php } ?>
    </form>
</div>

<?php include_once '../../private/shared/default_footer.php'; ?>