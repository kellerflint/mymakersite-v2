<?php require_once '../../private/initialize.php'; ?>
<?php require_role(ADM); ?>
<?php 
$page_title = 'Add Badge';
//$page_style = 'give';
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<?php 

$badge_update_id = '';
$badge_update_rank = 'Unranked';
$badge_update_title = '';
$badge_update_required = 'false';
$badge_update_link = '';
$badge_update_description = '';

if (request_is_post()) {
    if (isset($_POST['badge']) && $_POST['badge'] != 'none') {

        $badge_update_id = $_POST['badge'];
        $sql = "SELECT * FROM Badge WHERE badge_id = '" . $badge_update_id . "';";
        $update_badge_set = mysqli_query($db, $sql);
        $update_badge = mysqli_fetch_assoc($update_badge_set);

        confirm_result($update_badge);

        $badge_update_title = $update_badge['badge_title'];
        $badge_update_rank = $update_badge['rank_id'];
        $badge_update_required = $update_badge['badge_required'];
        $badge_update_link = $update_badge['badge_link'];
        $badge_update_description = $update_badge['badge_description'];

    }
} ?>

<div class="content">
    <h2>Add or Remove Badge</h2>
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
        <button name="submitbtn" id="create" value="create">Create Badge</button>
        <!--TODO: <button name="submitbtn" id="update" value="update"></button>-->
        <button name="submitbtn" id="delete" value="delete">Delete Badge</button>
    </form>

    <h2>Update Badge</h2>

    <form action="add_badge.php" method="POST">
        <label for="badge">Badge to Update</label>
        <select name="badge" id="badge" onchange="this.form.submit();">
            <option value="none">[NOT SELECTED]</option>
            <?php
            // Display all badges in dropdown
            $sql = "SELECT badge_id, badge_title FROM Badge;";
            $badge_set = mysqli_query($db, $sql);
            confirm_result($badge_set);
            while ($badge = mysqli_fetch_assoc($badge_set)) { ?>
            <option value="<?php echo $badge['badge_id']; ?>"
                <?php if ($badge_update_id == $badge['badge_id']) echo "selected='selected'"; ?>>
                <?php echo $badge['badge_title']; ?>
            </option>
            <?php 
        } ?>
        </select>
        <br>
        <br>
        <label for="rank">Update Badge Rank</label>
        <select name="rank" id="rank">
            <?php
            // Display all rank options in dropdown
            $ranks_set = find_all_ranks();
            confirm_result($ranks_set);
            while ($rank = mysqli_fetch_assoc($ranks_set)) { ?>
            <option value="<?php echo $rank['rank_title']; ?>"
                <?php if ($badge_update_rank == $rank['rank_id']) echo "selected='selected'"; ?>>
                <?php echo $rank['rank_title']; ?>
            </option>
            <?php 
        } ?>
        </select>
        <br>
        <label for="badge_title">Badge Title</label>
        <input type="text" id="badge_title" name="badge_title" value="<?php echo $badge_update_title; ?>">
        <br>
        <label for="badge_required">Required </label>
        <input type="checkbox" id="badge_required" name="badge_required" value="true"
            <?php if ($badge_update_required == 'true') echo "checked"; ?>>
        <br>
        <label for="badge-link">Badge Link</label>
        <input type="text" id="badge_link" name="badge_link" value="<?php echo $badge_update_link; ?>">
        <br>
        <label for="badge_description">Badge Description</label>
        <textarea name="badge_description" id="badge_description" cols="50" rows="5"><?php echo $badge_update_description; ?>
        </textarea>
        <br>
        <button name="submitbtn" id="update" value="update">Update Badge</button>
    </form>

</div>

<?php if (request_is_post()) {
    if (isset($_POST['submitbtn'])) {
        if ($_POST['submitbtn'] == 'create') {
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
            $sql .= "'" . hsc($badge_title) . "', ";
            $sql .= "'" . $rank['rank_id'] . "', ";
            $sql .= "'" . $badge_required . "', ";
            $sql .= "'" . hsc($badge_description) . "', ";
            $sql .= "'" . $badge_link . "', ";
            $sql .= "'" . $img . "');";

            $result = mysqli_query($db, $sql);

            if ($result) {
                echo "Created " . $badge_title . " badge.";
            } else {
                echo " Badge creation failed: " . mysqli_error($db);
            }
        } else if ($_POST['submitbtn'] == 'delete') {
            $badge_title = $_POST['badge_title'];

            $sql = "DELETE FROM Badge WHERE badge_title = '" . $badge_title . "';";
            $result = mysqli_query($db, $sql);

            if ($result) {
                echo "deleted badge " . $badge_title . ".";
            } else {
                echo " Badge deletion failed: " . mysqli_error($db);
            }
        // TODO implement badge update
        } else if ($_POST['submitbtn'] == 'update') {

            $badge_id = $_POST['badge'];

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

            $sql = "UPDATE Badge SET ";
            $sql .= "badge_title='" . hsc($badge_title) . "', ";
            $sql .= "rank_id='" . $rank['rank_id'] . "', ";
            $sql .= "badge_required='" . $badge_required . "', ";
            $sql .= "badge_link='" . hsc($badge_link) . "', ";
            $sql .= "badge_description='" . hsc($badge_description) . "' ";
            $sql .= "WHERE badge_id='" . $badge_id . "';";

            echo $sql . "<br>";

            $result = mysqli_query($db, $sql);

            if ($result) {
                echo "Updated " . $badge_title . ".";
            } else {
                echo "Update on " . $badge_title . " failed: " . mysqli_error($db);
            }

        }
    }
} ?>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>