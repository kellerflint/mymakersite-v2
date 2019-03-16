<?php require_once '../../private/initialize.php'; ?>
<?php 
    require_permission(ADM);
    $page_title = 'Create Badge';
    $page_style = 'badge';
?>

<?php if(request_is_post()) {
    
    $badge['badge_title'] = $_POST['badge_title'];
    $badge['rank_id'] = $_POST['rank_id'];
    $badge['badge_link'] = $_POST['badge_link'];
    $badge['badge_required'] = $_POST['badge_required'];
    $badge['badge_description'] = $_POST['badge_description'];
    
    $result = create_badge($badge);
    
    if ($result !== true) {
        $errors = $result;
    }
} ?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<form id="update-badge" action="create_badge.php" method="POST">
    <label for="title-edit">Title</label>
    <input name="badge_title" id="title-edit" type="text">
    <br>
    <label for="rank-edit">Rank</label>
    <select name="rank_id" id="rank-edit">
        <?php
            // Display all rank options in dropdown
            $ranks_set = find_rank_data($_SESSION['session_id']);
            while ($rank = mysqli_fetch_assoc($ranks_set)) { ?>
        <option value="<?php echo $rank['rank_id']; ?>">
            <?php echo $rank['rank_title']; ?>
        </option>
        <?php 
        } ?>
    </select>
    <br>
    <label for="link-edit">Link</label>
    <input name="badge_link" id="link-edit" type="text">
    <br>
    <label for="required-edit">Required</label>
    <input type="hidden" name="badge_required" id="required-edit-false" value="false">
    <input type="checkbox" name="badge_required" id="required-edit" value="true">
    <br>
    <label for="description-edit">Description</label>
    <textarea name="badge_description" id="description-edit" cols="50" rows="5"></textarea>
    <br>
    <button type="submit" name="submit" id="create" value="create">Create</button>
</form>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>