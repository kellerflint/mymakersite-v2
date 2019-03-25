<?php require_once('../../private/initialize.php'); ?>
<?php require_permission(VWR); ?>
<?php 
$page_title =  'Edit Profile';
$page_style = 'edit_profile';
?>

<?php include_once(SHARED_PATH . '/default_header.php'); ?>

<?php 
$style_id = '';
if (request_is_post()) {
    if (isset($style_id)) {
        $style_id = $_POST['style_id'];
    }
    update_profile_style($_SESSION['session_id'], $_SESSION['user_id'], $_POST['style_id']);
}
?>

<div class="content">
    <form action="edit_profile.php?user_id=<?php echo $_GET['user_id']?>" method="POST" id="styles-form">
        <input type="hidden" name="style_id" id="item_id" value="<?php echo $style_id; ?>">
    </form>
    <div id="styles">
        <?php 
        $style_set = find_profile_styles($_SESSION['session_id'], $_GET['user_id']);
        while($style = mysqli_fetch_assoc($style_set)) {?>
        <div class="style-wrapper" data-item="<?php echo $style['style_id']; ?>">
            <p><?php echo $style['style_title']; ?></p>
        </div>
        <?php } ?>
    </div>
</div>

<?php include_once(SHARED_PATH . '/default_footer.php'); ?>