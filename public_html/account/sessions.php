<?php require_once '../../private/initialize.php' ?>
<?php 
$page_title = 'Sessions';
$page_style = 'sessions'; 

require_login();
?>

<?php include_once '../../private/shared/default_header.php'; ?>

<div class="content">
    <h2>My Sessions</h2>
    <?php
    $session_set = find_sessions_by_user($_SESSION['user_id']);
    while ($session = mysqli_fetch_assoc($session_set)) { ?>

    <div class="session-wrapper">
        <p><?php echo $session['session_title']; ?></p>
    </div>

    <?php } ?>

</div>

<?php include_once '../../private/shared/default_footer.php'; ?>