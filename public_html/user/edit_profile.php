<?php require_once('../../private/initialize.php'); ?>
<?php require_permission(VWR); ?>
<?php 
$page_title =  'Edit Profile';
$page_style = 'edit_profile';
?>

<?php include_once(SHARED_PATH . '/default_header.php'); ?>

<div class="content">
    <form action="edit_profile.php" method="POST" id="sytles-form">
        <input type="hidden" name="style_id">
    </form>
    <div id="styles">
        <?php 
        $style_set = find_profile_styles($_SESSION['session_id'], $_GET['user_id']);
        while($style = mysqli_fetch_assoc($style_set)) { ?>
        <div class="style-wrapper">
            <p><?php echo $style['style_title']; ?></p>
        </div>
        <?php } ?>
    </div>
</div>

<?php include_once(SHARED_PATH . '/default_footer.php'); ?>