<?php require_once('../../private/initialize.php'); ?>
<?php require_permission(VWR); ?>
<?php 
$page_title = 'Ranks';
$page_style = 'ranks';
?>

<?php include_once(SHARED_PATH . '/default_header.php'); ?>

<div class="content">
    <h1>Ranks</h1>
    <?php $rank_set = find_rank_data($_SESSION['session_id']); 
    while ($rank = mysqli_fetch_assoc($rank_set)) {
    ?>
    <div class="rank-item">

        <h2><?php echo $rank['rank_title']; ?></h2>

        <img class="rank-img" src="<?php echo $rank['image_path']; ?>" alt="<?php echo $rank['rank_title']; ?>">

        <p><?php echo $rank['rank_description']; ?></p>
    </div>
    <?php } ?>
</div>

<?php include_once(SHARED_PATH . '/default_footer.php'); ?>