<?php require_once '../../private/initialize.php'; ?>

<?php $page_title = 'Leaderboard' ?>

<?php include_once SHARED_PATH . '/student_header.php'; ?>

<div class="content">

    <h2>Leaderboard</h2>

    <?php 
    $user_set = find_all_users();
    confirm_result($user_set);
    ?>

    <?php while ($user = mysqli_fetch_assoc($user_set)) { ?>
    <div class="user-container">

        <div class="image-container">

            <?php 
            $user_rank = find_user_rank($user['user_id']);
            confirm_result($user_rank);
            $rank_img = find_image($user_rank['image_id']);
            confirm_result($rank_img);
            ?>

            <img class="leader-rank-image" src="<?php echo $rank_img['image_path'] ?>">
        </div>
        <p class="leaderboard-name">
            <?php echo $user['first_name']; ?>
        </p>
    </div>
    <?php 
} ?>

</div>
<?php mysqli_free_result($user_set); ?>


<?php include_once SHARED_PATH . '/student_footer.php'; ?>