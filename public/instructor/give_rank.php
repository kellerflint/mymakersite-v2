<?php require_once '../../private/initialize.php'; ?>

<?php 
$page_title = 'Give Rank';
$page_style = 'give';
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<?php 
$user_name = '';
$rank_title = '';

if (request_is_post()) {
    $user_name = $_POST['username'];
    $rank_title = $_POST['rank'];
}
?>

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
            <input type="text" name="username" id="username" value="<?php echo $user_name; ?>">
            <br>
            <label for="username">Rank: </label>
            <input type="text" name="rank" id="rank" value="<?php echo $rank_title; ?>">
            <br>
            <button name="submit" value="pre">Check Prerequisites</button>
            <button name="submit" value="give">Give Rank</button>
            <button name="submit" value="remove">Remove Rank</button>
        </form>
        <!-- Results of the Check Prerequisites -->
        <div id="result">
            <?php 
            if (request_is_post()) { ?>

            <?php

            if ($_POST['submit'] == 'pre') {

                $user = find_user($user_name);
                confirm_result($user);

                $rank = find_rank($rank_title);
                confirm_result($rank);

                $full_badge_set = find_badges_for_rank($rank['rank_id']);
                confirm_result($full_badge_set);

                while ($badge = mysqli_fetch_assoc($full_badge_set)) {
                    $has_badge = false;
                    $user_badge_set = find_user_badges($user['user_id'], $rank['rank_id']);
                    confirm_result($user_badge_set);

                    while ($user_badge = mysqli_fetch_assoc($user_badge_set)) {
                        if ($user_badge['badge_id'] == $badge['badge_id']) {
                            $has_badge = true;
                        }
                    }
                    if ($has_badge == false) {
                        ?>
            <p class="warning">
                <?php echo 'WARNING: ' . $user_name . ' is missing the ' . $badge['badge_title'] . ' badge!'; ?></p>
            <?php 
        }
    }
} else if ($_POST['submit'] == 'remove') {
    $user = find_user($user_name);
    confirm_result($user);

    $rank = find_rank($rank_title);
    confirm_result($rank);

    $sql = "SELECT * FROM User_Rank WHERE user_id = " . $user['user_id'] . ";";
    $user_ranks_set = mysqli_query($db, $sql);
    
    // Only execute delete if the user has more than 1 badge (cannot remove a user's only badge)
    if (mysqli_num_rows($user_ranks_set) > 1) {
        $sql = "DELETE FROM User_Rank WHERE user_id = " . $user['user_id'] . " AND rank_id = " . $rank['rank_id'] . ";";
        $result = mysqli_query($db, $sql);

        if ($result) {
            echo "Rank " . $rank_title . " removed from user " . $user_name;
        } else {
            echo "Rank deletion failed: " . mysqli_error($db);
        }
    } else {
        echo "User must have at least one rank. If you wish to remove a badge, 
        you must first give the user the rank you want them to have and then remove the higher badges.";
    }



} else {

    $user = find_user($user_name);
    confirm_result($user);

    $rank = find_rank($rank_title);
    confirm_result($rank);

    $sql = "INSERT INTO User_Rank VALUES (" . $user['user_id'] . ", " . $rank['rank_id'] . ", now())";
    $result = mysqli_query($db, $sql);

    if ($result) {
        echo "Rank " . $rank_title . " given to user " . $user_name;
    } else {
        echo "Rank insert failed: " . mysqli_error($db);
    }

} ?>

            <?php 
            // Closing if request is post
        } ?>
        </div>
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

<script src="<?php echo '../../private/scripts/give_fill_form.js'; ?>"></script>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>