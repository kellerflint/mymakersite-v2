<?php require_once('../../private/initialize.php'); ?>
<?php require_permission(VWR); ?>
<?php $page_title = 'Progress' ?>
<?php $page_style = 'progress' ?>

<?php include_once(SHARED_PATH . '/default_header.php'); ?>


<div class="content">
    <?php $rank_set = find_rank_data($_SESSION['session_id']);
    while ($rank = mysqli_fetch_assoc($rank_set)) {
    ?>
    <div id="rank-image-wrapper">
        <img class="badge-rank-img" src="<?php echo $rank['image_path']; ?>" alt="<?php echo $rank['rank_title']; ?>">
    </div>
    <?php $badge_set = find_user_badges($_SESSION['user_id'], $rank['rank_id']);
        while ($badge = mysqli_fetch_assoc($badge_set)) { 
            $class_list = "";
            if ($badge['badge_earned'] == 'true') {
                $class_list .= "earned ";
            }
            if ($badge['badge_required'] == 'true') {
                $class_list .= "required ";
            }
        ?>
    <a class="badge-a" href="<?php echo url_for('/user/badge.php?id=' . $badge['badge_id']); ?>">
        <div class="badge-item <?php echo $class_list; ?>">

            <img class="badge-image" src="<?php echo $badge['image_path']; ?>"
                alt="<?php echo $badge['badge_title']; ?>">

            <h2><?php echo $badge['badge_title']; ?></h2>
        </div>
    </a>
    <?php } } ?>
</div>


<?php include_once(SHARED_PATH . '/default_footer.php'); ?>