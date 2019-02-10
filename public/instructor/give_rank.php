<?php require_once '../../private/initialize.php'; ?>

<?php 
$page_title = 'Give Rank';
$page_style = 'give_rank';
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<?php if (request_is_post()) { ?>

<?php 

$user_name = $_POST['username'];
$rank_title = $_POST['rank'];

$user = find_user($user_name);
confirm_result($user);

$rank = find_rank($rank_title);
confirm_result($rank);

$badge_set = find_user_badges($user['user_id'], $rank['rank_id']);
confirm_result($badge_set);

while ($badge = mysqli_fetch_assoc($badge_set)) {
    echo $badge['badge_title'];
    //select * from Badge where rank_id = 2 and badge_required = "true";
}

?>

<?php 
} else { ?>

<div class="content">

    <div id="user-box">
        <h2>Users</h2>
        <?php 
        $user_set = find_all_users();
        confirm_result($user_set);
        $user_count = 0;
        while ($user = mysqli_fetch_assoc($user_set)) {
            $ranks_set = find_user_ranks($user['user_id']);
            confirm_result($ranks_set);
            $rank = mysqli_fetch_assoc($ranks_set);
            $rank_img = find_image($rank['image_id']);
            confirm_result($rank_img);
            ?>

        <div data-user="<?php echo $user['user_name'] ?>"
            class="user-item 
            <?php
            if ($user_count % 2 == 0) echo 'even';
            else echo 'odd'; ?>">
            <p>
                <?php echo $user['user_first'] . ' ' . $user['user_last'] . ' [' . $user['user_name'] . ']'; ?>
                <img class="rank-img-user" src="<?php echo $rank_img['image_path']; ?>" alt="">
            </p>
        </div>

        <?php
        $user_count++;
    } ?>

    </div>

    <div id="form-box">
        <form action="give_rank.php" method="POST">
            <label for="username">Username: </label>
            <input type="text" name="username" id="username">
            <br>
            <label for="username">Rank: </label>
            <input type="text" name="rank" id="rank">
            <br>
            <button name="submit">Check Prerequisites</button>
        </form>
    </div>

    <div id="rank-box">
        <h2>Ranks</h2>
        <?php 
        $rank_set = find_all_ranks();
        confirm_result($rank_set);
        $rank_count = 0;
        while ($rank = mysqli_fetch_assoc($rank_set)) {
            $rank_img = find_image($rank['image_id']);
            confirm_result($rank_img); ?>

        <div data-rank="<?php echo $rank['rank_title']; ?>"
            class=" rank-item 
            <?php if ($rank_count % 2 == 0) echo 'even';
            else echo 'odd'; ?>">
            <p>
                <img class="rank-img-rank" src="<?php echo $rank_img['image_path']; ?>"
                    alt="<?php echo $rank_img['image_name']; ?>">
            </p>
        </div>

        <?php
        $rank_count++;
    } ?>

    </div>

</div>

<?php 
} ?>

<script src="<?php echo '../../private/scripts/rank_fill_form.js'; ?>"></script>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>