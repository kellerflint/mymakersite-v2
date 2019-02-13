<?php require_once '../../private/initialize.php'; ?>

<?php 
$page_title = 'Add Badge';
//$page_style = 'give';
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<div class="content">
    <form action="add_badge.php" method="POST">
        <label for="badge_title">Badge Title</label>
        <input type="text" id="badge_title" name="badge_title">
        <br>
        <label for="rank">Badge Rank</label>
        <select name="rank" id="rank">
            <?php
            // Display all rank options in dropdown
            $ranks_set = find_all_ranks();
            confirm_result($ranks_set);
            while ($rank = mysqli_fetch_assoc($ranks_set)) { ?>
            <option value="<?php echo $rank['rank_title']; ?>">
                <?php echo $rank['rank_title']; ?>
            </option>
            <?php 
        } ?>
        </select>
        <br>
        <label for="badge_required">Required </label>
        <input type="checkbox" id="badge_required" name="badge_required" value="true">
        <br>
        <label for="badge-link">Badge Link</label>
        <input type="text" id="badge_link" name="badge_link">
        <br>
        <label for="badge_description">Badge Description</label>
        <textarea name="badge_description" id="badge_description" cols="50" rows="5"></textarea>
        <br>
        <button name="submit" id="create" value="create">Create Badge</button>
        <!--TODO: <button name="submit" id="update" value="update"></button>-->
        <button name="submit" id="delete" value="delete">Delete Badge</button>
    </form>
</div>

<?php if (request_is_post()) {
    if ($_POST['submit'] == 'create') {
        $badge_title = $_POST['badge_title'];
        $badge_rank = $_POST['rank'];

        $badge_required = 'false';
        if (isset($_POST['badge_required']))
            $badge_required = $_POST['badge_required'];

        $badge_link = $_POST['badge_link'];
        $badge_description = $_POST['badge_description'];

        $image_assoc = find_image("badge_default");
        confirm_result($image_assoc);
        $img = $image_assoc['image_id'];

        $rank = find_rank($badge_rank);
        confirm_result($rank);

        $sql = "INSERT INTO Badge VALUES(default, ";
        $sql .= "'" . $badge_title . "', ";
        $sql .= "'" . $rank['rank_id'] . "', ";
        $sql .= "'" . $badge_required . "', ";
        $sql .= "'" . $badge_description . "', ";
        $sql .= "'" . $badge_link . "', ";
        $sql .= "'" . $img . "');";

        $result = mysqli_query($db, $sql);

        if ($result) {
            echo "Created " . $badge_title . " badge.";
        } else {
            echo " Badge creation failed: " . mysqli_error($db);
        }
    } else if ($_POST['submit'] == 'delete') {
        $badge_title = $_POST['badge_title'];

        $sql = "DELETE FROM Badge WHERE badge_title = '" . $badge_title . "';";
        $result = mysqli_query($db, $sql);

        if ($result) {
            echo "deleted badge " . $badge_title . ".";
        } else {
            echo " Badge deletion failed: " . mysqli_error($db);
        }
        // TODO implement badge update
    } else if ($_POST['submit'] == 'update') {
        $badge = $_POST['badge_title'];

        $sql = "UPDATE Badge SET ";
        $sql .= "";
    }

} ?>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>