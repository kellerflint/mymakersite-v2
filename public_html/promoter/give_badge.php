<?php require_once '../../private/initialize.php'; ?>
<?php require_permission(PMT); ?>

<?php 
$page_title = 'Give Badge';
$page_style = 'give';
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<?php 
// Default form submit values
$rank_id = '1';
$user_id = '';
$badge_id = '';

// Defaults are overriden on submission if they are set
if (request_is_post()) {
    if (isset($_POST['rank_id']))
        $rank_id = $_POST['rank_id'];
    if (isset($_POST['user_id']))
        $user_id = $_POST['user_id'];
    if (isset($_POST['badge_id']))
        $badge_id = $_POST['badge_id'];
}
?>

<div class="content">
    <div id="user-box">
        <h2>Users</h2>
        <?php 
        // Get and confirm user set
        $user_set = find_users_by_session($_SESSION['session_id']);
        // Iterate over users and displays names
        $count = 0;
        while ($user = mysqli_fetch_assoc($user_set)) { ?>
        <div data-user="<?php echo $user['user_id'] ?>" class="user-item 
            <?php echo even_odd($count); ?>">
            <p>
                <?php echo $user['user_first'] . ' ' . $user['user_last']; ?>
                <br>
                <img class="rank-img-user" src="<?php echo $rank['image_path']; ?>" alt="">
            </p>
        </div>
        <?php $count++;
    } ?>
        <!-- End of userbox -->
    </div>

    <div id="form-box">
        <form action="give_badge.php" method="POST" id="badge-form">
            <label for="rank_id">Badge Rank: </label>
            <select name="rank_id" id="rank_id" onchange="this.form.submit();">
                <?php
                // Display all rank options in dropdown
                $rank_set = find_rank_data($_SESSION['session_id']);
                while ($rank = mysqli_fetch_assoc($rank_set)) { ?>
                <option value="<?php echo $rank['rank_id']; ?>" <?php 
                    // Select this rank if same as for_rank from $_GET
                    if ($rank_id == $rank['rank_id'])
                        echo "selected='selected'";
                    ?>>
                    <?php echo $rank['rank_title']; ?>
                </option>
                <?php 
            } ?>
            </select>
            <br>
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="badge_id" id="item_id" value="<?php echo $badge_id; ?>">
            <button name="submit-option" value="give" id="give">Give
                Badge</button>
            <button name="submit-option" value="remove" id="remove">Remove
                Badge</button>
        </form>
        <!-- Displays result of give badge query -->
        <div id=" result-box">
            <?php 
            if (request_is_post()) {
            // if submit-option is set then run give or remove, else run update
                if (isset($_POST['submit-option'])) {
                    if ($_POST['submit-option'] == 'give') {
                        give_badge($user_id, $badge_id);
                    } else if ($_POST['submit-option'] == 'remove') {
                        remove_badge($user_id, $badge_id);
                    }
                }
                display_user_badges($user_id, $rank_id);
            } ?>
        </div>
        <!--End of form div-->
    </div>
    <div id="badge-box">
        <h2>Missing Badges: </h2>
        <?php 
        if (request_is_post()) {
            if (!is_empty($user_id)) {
                $badge_set = find_user_badges($user_id, $rank_id);
                $count = 0;
                while ($badge = mysqli_fetch_assoc($badge_set)) {
                    if ($badge['badge_earned'] === 'false') { 
                    ?>
        <div data-rank="<?php echo $badge['badge_id']; ?>" class="badge-item 
        <?php echo even_odd($count); ?>">
            <p>
                <?php 
                echo $badge['badge_title'];
                if ($badge['badge_required'] == 'true')
                    echo "*";
                ?>
            </p>
        </div>

        <?php } $count++;
    }
}
}
?>
    </div>
</div>


</div>
<?php include_once SHARED_PATH . '/default_footer.php'; ?>

<?php 
// Page function definitions

// Shows users current badges
function display_user_badges($user_id, $rank_id)
{
?>
<h2>Current Badges:</h2>
<?php
    if (!is_empty($user_id)) {
        $badge_set = find_user_badges($user_id, $rank_id);
        $count = 0;
        while ($badge = mysqli_fetch_assoc($badge_set)) { 
            if ($badge['badge_earned'] === 'true') { ?>
<div data-rank="<?php echo $badge['badge_id']; ?>" class="badge-item 
        <?php echo even_odd($count); ?>">
    <p>
        <?php 
            echo $badge['badge_title'];
            if ($badge['badge_required'] == 'true')
                echo "*";
        ?>
    </p>
</div>

<?php } $count++;
}
}
}
// Given user_name and badge_title gives user badge or displays errors
function give_badge($user_id, $badge_id)
{
    if (!is_empty($user_id) && !is_empty($badge_id)) {
        $result = give_user_badge($user_id, $badge_id, $_SESSION['user_id']);
    } else {
        echo "Badge insert failed: You must select a user and a badge.";
    }
}
function remove_badge($user_id, $badge_id) {
    if (!is_empty($user_id) && !is_empty($badge_id)) {
        $result = remove_user_badge($user_id, $badge_id);
    } else {
        echo "Badge deletion failed: You must select a user and badge.";
    }
}
?>