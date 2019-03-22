<?php require_once('../../private/initialize.php'); ?>
<?php require_permission(VWR); ?>
<?php 
$page_title = $_SESSION['user_name'];
$page_style = 'profile';
?>

<?php include_once(SHARED_PATH . '/default_header.php'); ?>

<?php 
if (request_is_post()) {
    $user = find_user_by_id($_POST['user_id']);
    $rank = find_rank_by_user($_SESSION['session_id'], $user['user_id']);
}
?>

<div class="content">
    <div class="profile">
        <img src="<?php echo $rank['image_path']; ?>" alt="<?php echo $rank['image_title']; ?>" class="rank-image">
        <p><?php echo $user['user_first'] . ' ' . $user['user_last']; ?></p>
    </div>
    <div class="badges">
        <?php 
        $badge_set = find_profile_badges($_SESSION['session_id'], $user['user_id']);
        while($badge = mysqli_fetch_assoc($badge_set)) { 
            ?>
        <div class="badge-item <?php echo $class_list; ?>">
            <a class="badge-a" href="<?php echo url_for('/user/badge.php?id=' . $badge['badge_id']); ?>">

                <img class="badge-image" src="<?php echo $badge['image_path']; ?>"
                    alt="<?php echo $badge['badge_title']; ?>">

                <h3><?php echo $badge['badge_title']; ?></h3>
            </a>
        </div>

        <?php } ?>
    </div>
</div>

<?php include_once(SHARED_PATH . '/default_footer.php'); ?>