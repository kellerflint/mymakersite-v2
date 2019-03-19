<?php require_once '../../private/initialize.php'; ?>
<?php require_permission(PMT); ?>

<?php 
$page_title = 'Give Rank';
$page_style = 'give';
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<?php 
$user_id = '';
$rank_id = '';
if (request_is_post()) {
    $user_id = $_POST['user_id'];
    $rank_id = $_POST['rank_id'];
}
?>

<div class="content">

    <div id="user-box">
        <h2>Users</h2>
        <?php 
        $user_set = find_users_by_session($_SESSION['session_id']);
        $user_count = 0;
        while ($user = mysqli_fetch_assoc($user_set)) {
            $rank = find_rank_by_user($_SESSION['session_id'], $user['user_id']);
            ?>

        <div data-user="<?php echo $user['user_id'] ?>" class="user-item 
            <?php echo even_odd($user_count); ?>">
            <p>
                <?php echo $user['user_first'] . ' ' . $user['user_last']; ?>
                <br>
                <img class="rank-img-user" src="<?php echo $rank['image_path']; ?>"
                    alt="<?php echo $rank['rank_title']; ?>">
            </p>
        </div>

        <?php
        $user_count++;
    } ?>

    </div>

    <div id="form-box">
        <form action="give_rank.php" method="POST">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="rank_id" id="item_id" value="<?php echo $rank_id; ?>">
            <button name="submit" value="pre">Check Prerequisites</button>
            <br>
            <button name="submit" value="give" id="give">Give Rank</button>
            <br>
            <button name="submit" value="remove" id="remove">Remove Rank</button>
        </form>
        <!-- Results of the Check Prerequisites -->
        <div id="result">
            <?php 
                if (request_is_post()) { form_options(); }
            ?>
        </div>
    </div>

    <div id="rank-box">
        <h2>Ranks</h2>
        <?php 
        $rank_set = find_rank_data($_SESSION['session_id']);
        $rank_count = 0;
        while ($rank = mysqli_fetch_assoc($rank_set)) { ?>
        <h3><?php echo $rank['rank_title']; ?></h3>
        <div data-rank="<?php echo $rank['rank_id']; ?>" class="rank-item 
            <?php echo even_odd($rank_count); ?>">
            <p>
                <img class="rank-img-rank" src="<?php echo $rank['image_path']; ?>"
                    alt="<?php echo $rank['rank_title']; ?>">
            </p>
        </div>

        <?php
        $rank_count++;
    } ?>

    </div>

</div>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>

<?php
function form_options() {
    if ($_POST['submit'] == 'pre') {
        $missing_badge_html = '';
        $badge_set = find_user_badges($_POST['user_id'], $_POST['rank_id']);
        while ($badge = mysqli_fetch_assoc($badge_set)) {
            if ($badge['badge_required'] === 'true' && $badge['badge_earned'] === 'false') {
                $missing_badge_html =  "<h2>" . $badge['badge_title'] . "</h2>";
            }
        }
        if (!is_empty($missing_badge_html)) {
            echo "<h1 class='red'>Missing Badges</h1>";
            echo $missing_badge_html;   
        } else {
            echo "<h1 class='green'>Prerequisites Met</h1>";
        }
        
    } else if ($_POST['submit'] == 'remove') {
        remove_user_rank($_POST['user_id'], $_POST['rank_id']);
        redirect_to(url_for('/promoter/give_rank.php'));
    } else if ($_POST['submit'] == 'give') {
        give_user_rank($_POST['user_id'], $_POST['rank_id'], $_SESSION['session_id']);
        redirect_to(url_for('/promoter/give_rank.php'));
    }
}

?>