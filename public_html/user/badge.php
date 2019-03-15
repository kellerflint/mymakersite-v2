<?php require_once('../../private/initialize.php'); ?>
<?php require_permission(VWR); ?>
<?php $page_title = 'Badge' ?>
<?php $page_style = 'badge' ?>

<?php include_once(SHARED_PATH . '/default_header.php'); ?>


<div class="content">
    <?php $badge = find_badge_by_id($_GET['id']); ?>
    <h1><?php echo $badge['badge_title']; ?></h1>
    <p>Link: <a class="badge-link" href="<?php echo $badge['badge_link']; ?>"><?php echo $badge['badge_link']; ?></a>
    </p>

    <p>Required: <?php echo $badge['badge_required']; ?></p>

    <p>Description: <?php echo $badge['badge_description']; ?></p>

</div>


<?php include_once(SHARED_PATH . '/default_footer.php'); ?>