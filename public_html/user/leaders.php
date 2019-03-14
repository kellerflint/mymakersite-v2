<?php require_once '../../private/initialize.php'; ?>
<?php require_permission(VWR); ?>
<?php 
$page_title = 'Leaders';
$page_style = 'leaders'; 
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<div class="content">

    <h2>Leaders</h2>

    <?php 
    $leader_set = find_leader_data($_SESSION['session_id']);
    while ($leader = mysqli_fetch_assoc($leader_set)) {
        if (has_permission($_SESSION['session_id'], $leader['user_id'], USR)) {
    ?>

    <div class="user-container">

        <div class="image-container">
            <img class="leader-rank-image" src="<?php echo $leader['image_path']; ?>"
                alt="<?php echo $leader['rank_title']; ?>">
        </div>

        <p class="leader-name"><?php echo $leader["user_first"]; ?></p>

    </div>

    <?php } } ?>

</div>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>