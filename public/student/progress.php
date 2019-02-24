<?php require_once('../../private/initialize.php'); ?>
<?php require_role(STU); ?>
<?php $page_title = 'Progress' ?>
<?php $page_style = 'progress' ?>

<?php include_once(SHARED_PATH . '/default_header.php'); ?>


<div class="content">

    <?php 
    $ranks = array('Novice', 'Apprentice', 'Adept', 'Expert', 'Master');
    foreach ($ranks as $rank) { ?>
    <div id="rank-image-wrapper">
        <img class="badge-rank-img" src="<?php echo WWW_ROOT . '/style/img/rank/' . strtolower($rank) . ".png"; ?>" .
            alt="<?php echo $rank; ?>">
    </div>
    <?php 
    $sql = "SELECT * FROM Badge WHERE rank_id = (SELECT rank_id FROM Rank WHERE rank_title = '" . $rank . "' );";

    $badge_set = mysqli_query($db, $sql);
    confirm_result($badge_set);

    while ($badge = mysqli_fetch_assoc($badge_set)) {
        $sql = "SELECT * FROM Image WHERE image_id = '" . $badge['image_id'] . "'";
        $image_set = mysqli_query($db, $sql);
        $image = mysqli_fetch_assoc($image_set);
        ?>

    <div class="badge-item">

        <a href="<?php echo $badge['badge_link']; ?>" target="_blank">
            <img class="badge-image 
            <?php
            if ($badge['badge_required'] == 'true') {
                echo 'required';
            }
             /* TODO: implement unearned badges are faded */
            ?>"
                src="<?php echo $image['image_path']; ?>" alt="<?php echo $image['image_name']; ?>">
        </a>
        <h2><?php echo $badge['badge_title']; ?></h2>
        <p><?php echo $badge['badge_description']; ?></p>

    </div>

    <?php 
} ?>



    <?php 
} ?>
</div>


<?php include_once(SHARED_PATH . '/default_footer.php'); ?>