<?php require_once '../../private/initialize.php'; ?>

<?php 
$page_title = 'Give Badge';
$page_style = 'give';
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<?php 

// Default form submit values
$user_name = '';
$badge_title = '';
$for_rank = 'Unranked';

// Defaults are overriden on submission if they are submitted TODO
if (request_is_post()) {
    $user_name = $_POST['username'];
    $badge_title = $_POST['badge'];
}

?>

<div class="content">

    <div id="user-box">
        <h2>Users</h2>
        <?php 

        // Get and confirm user set
        $user_set = find_all_users();
        confirm_result($user_set);

        // Iterate over all users, display name
        while ($user = mysqli_fetch_assoc($user_set)) {
            ?>
        <div data-user="<?php echo $user['user_name'] ?>" class="user-item 
            ">
            <p class="user-p">
                <?php echo $user['user_first'] . ' ' . $user['user_last']; ?>
            </p>
        </div>
        <?php 
    } ?>
        <!-- End of userbox -->
    </div>

    <div id="form-box">
        <form action="give_badge.php" method="POST">
            <label for="username">Username: </label>
            <input type="text" name="username" id="username" value="<?php echo $user_name; ?>">
            <br>
            <label for="badge">Badge: </label>
            <input type="text" name="badge" id="badge" value="<?php echo $badge_title; ?>">
            <br>
            <button name="submit" value="give">Give Badge</button>
            <button name="submit" value="remove">Remove Badge</button>
        </form>
        <!-- Displays result of give badge query -->
        <div id="result">
            <?php 
            if (request_is_post()) {
                if ($_POST['submit'] == 'give') {
                    $user = find_user($user_name);
                    confirm_result($user);

                    $badge = find_badge($badge_title);
                    confirm_result($badge);

                    $sql = "INSERT INTO User_Badge VALUES (" . $user['user_id'] . ", " . $badge['badge_id'] . ", now())";
                    $result = mysqli_query($db, $sql);

                    if ($result) {
                        echo "Badge " . $badge_title . " given to user " . $user_name;
                    } else {
                        echo "Badge insert failed: " . mysqli_error($db);
                    }
                } else {
                    $user = find_user($user_name);
                    confirm_result($user);

                    $badge = find_badge($badge_title);
                    confirm_result($badge);

                    $sql = "DELETE FROM User_Badge WHERE user_id = " . $user['user_id'] . " AND badge_id = " . $badge['badge_id'] . ";";
                    $result = mysqli_query($db, $sql);

                    if ($result) {
                        echo "Rank " . $badge_title . " removed from user " . $user_name;
                    } else {
                        echo "Rank deletion failed: " . mysqli_error($db);
                    }

                }

            } ?>
        </div>
    </div>

    <div id="badge-box">
        <form action="give_badge.php" method="GET" id="ranks-form">
            <select name="ranks" id="rank-options" onchange="this.form.submit();">
                <?php 
                $ranks_set = find_all_ranks();
                confirm_result($ranks_set);
                while ($rank = mysqli_fetch_assoc($ranks_set)) { ?>
                <option value="<?php echo $rank['rank_title'] ?>">
                    <?php echo $rank['rank_title']; ?>
                </option>
                <?php 
            } ?>
            </select>
        </form>
        <h2>Badges for <?php echo $for_rank; ?></h2>
        <?php 
        $rank = find_rank($for_rank);
        $badge_set = find_badges_for_rank($rank['rank_id']);
        confirm_result($badge_set);
        $badge_count = 0;
        while ($badge = mysqli_fetch_assoc($badge_set)) {
            $badge_img = find_image($badge['image_id']);
            confirm_result($badge_img); ?>

        <div data-rank="<?php echo $badge['badge_title']; ?>"
            class="badge-item 
            <?php if ($badge_count % 2 == 0) echo 'even';
            else echo 'odd'; ?>">
            <p> <?php echo $badge['badge_title']; ?>
                <img class="badge-img" src="<?php echo $badge_img['image_path']; ?>"
                    alt="<?php echo $badge_img['image_name']; ?>">
            </p>
        </div>

        <?php
        $badge_count++;
    } ?>

    </div>

</div>

<script src="<?php echo '../../private/scripts/give_fill_form.js'; ?>"></script>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>