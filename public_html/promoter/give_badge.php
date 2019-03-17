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
$badge_title = '';

// Defaults are overriden on submission if they are set
if (request_is_post()) {
    if (isset($_POST['rank_id']))
        $rank_id = $_POST['rank_id'];
    if (isset($_POST['user_id']))
        $user_id = $_POST['user_id'];
    if (isset($_POST['badge']))
        $badge_title = $_POST['badge'];
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
            <p class="user-p">
                <?php echo $user['user_first'] . ' ' . $user['user_last']; ?>
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
            <label for="user_id">User_id: </label>
            <input type="text" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
            <br>
            <label for="badge">Badge: </label>
            <input type="text" name="badge" id="badge" value="<?php echo $badge_title; ?>">
            <br>
            <button name="submit-option" value="give" onclick="this.form.submit();">Give
                Badge</button>
            <button name="submit-option" value="remove" onclick="this.form.submit();">Remove
                Badge</button>
        </form>
        <!-- Displays result of give badge query -->
        <div id="result-box">
            <?php 
            if (request_is_post()) {
            // if submit-option is set then run give or remove, else run update
                if (isset($_POST['submit-option'])) {
                    if ($_POST['submit-option'] == 'give') {
                        give_badge($user_name, $badge_title);
                    } else if ($_POST['submit-option'] == 'remove') {
                        remove_badge($user_name, $badge_title);
                    }
                }
                display_user_badges($user_id, $rank_id);
            } ?>
        </div>
        <!--End of form div-->
    </div>
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
    <div data-rank="<?php echo $badge['badge_title']; ?>" class="badge-item 
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
<div data-rank="<?php echo $badge['badge_title']; ?>" class="badge-item 
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
function give_badge($user_name, $badge_title)
{
    global $db;
    if ($user_name != '' && $badge_title != '') {
        $user = find_user($user_name);
        confirm_result($user);
        $badge = find_badge($badge_title);
        confirm_result($badge);
        $sql = "INSERT INTO User_Badge VALUES (" . $user['user_id'] . ", ";
        $sql .= $badge['badge_id'] . ", now())";
        $result = mysqli_query($db, $sql);
        if ($result) {
            echo "Badge " . $badge_title . " given to user " . $user_name;
        } else {
            echo "Badge insert failed: " . mysqli_error($db);
        }
    } else {
        echo "Badge insert failed: You must select a user and a badge.";
    }
}
function remove_badge($user_name, $badge_title)
{
    global $db;
    if ($user_name != '' && $badge_title != '') {
        $user = find_user($user_name);
        confirm_result($user);
        $badge = find_badge($badge_title);
        confirm_result($badge);
        $sql = "DELETE FROM User_Badge WHERE user_id = " . $user['user_id'];
        $sql .= " AND badge_id = " . $badge['badge_id'] . ";";
        $result = mysqli_query($db, $sql);
        if ($result) {
            echo "Rank " . $badge_title . " removed from user " . $user_name;
        } else {
            echo "Rank deletion failed: " . mysqli_error($db);
        }
    } else {
        echo "Badge deletion failed: You must select a user and badge.";
    }
}
?>