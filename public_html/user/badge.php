<?php require_once('../../private/initialize.php'); ?>
<?php require_permission(VWR); ?>
<?php 
// If user inputs id for badge not in their session, redirects them back to progress.php
if ($_SESSION['session_id'] != find_badge_session_by_id($_GET['id'])['session_id']) {
    redirect_to(url_for("/user/progress.php"));
}
?>
<?php $page_title = 'Badge' ?>
<?php $page_style = 'badge' ?>

<?php include_once(SHARED_PATH . '/default_header.php'); ?>

<?php if(request_is_post()) {
    
    $badge['badge_id'] = $_GET['id'];
    $badge['badge_title'] = $_POST['badge_title'];
    $badge['rank_id'] = $_POST['rank_id'];
    $badge['badge_link'] = $_POST['badge_link'];
    $badge['badge_required'] = $_POST['badge_required'];
    $badge['badge_description'] = $_POST['badge_description'];
    
    if ($_POST['submit'] == 'delete') {
        $result = delete_badge($badge['badge_id']);

        if ($result === true) {
            redirect_to(url_for("/user/progress.php"));
        }

    } else if ($_POST['submit'] == 'update') {
        $result = edit_badge($badge);
    }

    if ($result !== true) {
        $errors = $result;
    }
} ?>

<div class="content">
    <?php $badge = find_badge_by_id($_GET['id']); ?>
    <h1 for="title-edit"><?php echo $badge['badge_title']; ?></h1>
    <p>Rank: <?php echo $badge['rank_title']; ?></p>
    <p>Link: <a class="badge-link" href="<?php echo $badge['badge_link']; ?>"><?php echo $badge['badge_link']; ?></a>
    </p>

    <p>Required: <?php echo $badge['badge_required']; ?></p>

    <p>Description: <?php echo $badge['badge_description']; ?></p>
</div>

<?php if (check_permission(ADM)) { ?>

<form id="update-badge" action="badge.php?id=<?php echo $badge['badge_id']; ?>" method="POST">
    <label for="title-edit">Edit Title</label>
    <input name="badge_title" id="title-edit" type="text" value="<?php echo $badge['badge_title']; ?>">
    <br>
    <label for="rank-edit">Edit Rank</label>
    <select name="rank_id" id="rank-edit">
        <?php
            // Display all rank options in dropdown
            $ranks_set = find_rank_data($_SESSION['session_id']);
            while ($rank = mysqli_fetch_assoc($ranks_set)) { ?>
        <option value="<?php echo $rank['rank_id']; ?>"
            <?php if ($badge['rank_title'] == $rank['rank_title']) echo "selected='selected'"; ?>>
            <?php echo $rank['rank_title']; ?>
        </option>
        <?php 
        } ?>
    </select>
    <br>
    <label for="link-edit">Edit Link</label>
    <input name="badge_link" id="link-edit" type="text" value="<?php echo $badge['badge_link']; ?>">
    <br>
    <label for="required-edit">Edit Required</label>
    <input type="hidden" name="badge_required" id="required-edit-false" value="false">
    <input type="checkbox" name="badge_required" id="required-edit" value="true"
        <?php if ($badge['badge_required'] == 'true') echo "checked"; ?>>
    <br>
    <label for="description-edit">Edit Description</label>
    <textarea name="badge_description" id="description-edit" cols="50" rows="5"><?php echo $badge['badge_description']; ?>
    </textarea>
    <br>
    <button type="submit" name="submit" id="update" value="update">Update</button>
    <button type="submit" name="submit" id="delete" value="delete">Delete</button>
</form>
<?php } ?>

<?php echo display_errors($errors); ?>

<?php include_once(SHARED_PATH . '/default_footer.php'); ?>