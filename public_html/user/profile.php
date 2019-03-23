<?php require_once('../../private/initialize.php'); ?>
<?php require_permission(VWR); ?>
<?php 
$page_title = $_SESSION['user_name'];
$page_style = 'profile/default';
?>

<?php include_once(SHARED_PATH . '/default_header.php'); ?>

<?php 
$user = find_user_by_id($_GET['user_id']);
$rank = find_rank_by_user($_SESSION['session_id'], $user['user_id']);
?>

<div class="content">
    <div id="profile">
        <img src="<?php echo $rank['image_path']; ?>" alt="<?php echo $rank['image_title']; ?>" class="rank-image">
        <h1><?php echo $user['user_first'] . ' ' . $user['user_last']; ?></h1>
    </div>
    <div id="buttons">
        <a href="<?php echo url_for('/user/edit_profile.php?user_id=' . $user['user_id']);?>">
            <button>Edit Profile</button>
        </a>
    </div>
    <div id="badges">
        <?php 
        $badge_set = find_profile_badges($_SESSION['session_id'], $user['user_id']);
        while($badge = mysqli_fetch_assoc($badge_set)) { 
            ?>
        <div class=" badge-item <?php echo $class_list; ?>">
            <img class="badge-image" src="<?php echo $badge['image_path']; ?>"
                alt="<?php echo $badge['badge_title']; ?>">

            <h3><?php echo $badge['badge_title']; ?></h3>
        </div>

        <?php } ?>
    </div>
</div>

<?php include_once(SHARED_PATH . '/default_footer.php'); ?>