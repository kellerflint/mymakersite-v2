<?php require_once '../../private/initialize.php'; ?>
<?php
require_permission(MNG);
$page_title = 'Add User';
$page_style = 'add_user';
?>


<?php include_once SHARED_PATH . '/default_header.php'; ?>

<?php
// Default form submit values
$user_id = '';

// Defaults are overriden on submission if they are set
if (request_is_post()) {
    if (isset($_POST['user_id']))
        $user_id = $_POST['user_id'];
}
?>

<!--Should double as remove user-->

<!--right side should be list of users in your session, center form box for submit add/remove user,
    left side should be searchable input name [shows names close to the one or max out at 10 closest or something]-->

<!--Also need an edit session metadata page for owners-->

<div class="content">
    <div id="user-box">
        <h2>Users</h2>
        <?php
        $user_set = find_users_by_session($_SESSION['session_id']);
        $user_count = 0;
        while ($user = mysqli_fetch_assoc($user_set)) {
            ?>

        <div data-user="<?php echo $user['user_id']; ?>" class="user-item 
                                    <?php echo even_odd($user_count); ?>">
            <p>
                <?php echo $user['user_first'] . ' ' . $user['user_last']; ?>
            </p>
        </div>

        <?php
            $user_count++;
        } ?>
    </div>

    <form action="add_user.php" id="form-box" method="POST">
        <label for="search">Search For Username</label>
        <input type="text" name="search" id="search">
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
        <button name="submit-option" value="search" id="search">Search</button>
        <button name="submit-option" value="add" id="add">Add</button>
        <button name="submit-option" value="remove" id="remove">Remove</button>
    </form>

    <div id="global-user-box">
        <h2>Global User List</h2>
        <?php
        if (request_is_post()) {
            display_results();
            if ($_POST['submit-option'] == "search") {
                display_results();
            } else if ($_POST['submit-option'] == "add") {
                add_user_session($_SESSION['session_id'], $_POST['user_id']);
                redirect_to(url_for('/manager/add_user.php'));
            } else if ($_POST['submit-option'] == "remove") {
                remove_user_session($_SESSION['session_id'], $_POST['user_id']);
                redirect_to(url_for('/manager/add_user.php'));
            }
        }
        ?>
    </div>
</div>


<?php include_once SHARED_PATH . '/default_footer.php'; ?>

<?php
function display_results()
{
    $user_set = find_users_like($_SESSION['session_id'], $_POST['search']);
    $user_count = 0;
    while ($user = mysqli_fetch_assoc($user_set)) {
        ?>
<div data-user="<?php echo $user['user_id']; ?>" class="user-item 
                                                                        <?php echo even_odd($user_count); ?>">
    <p>
        <?php echo $user['user_name']; ?>
    </p>
</div>
<?php $user_count++;
    }
}
?>