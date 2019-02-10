<?php require_once('../../private/initialize.php'); ?>

<?php 
$page_title = 'Ranks';
$page_style = 'ranks';
?>

<?php include_once(SHARED_PATH . '/student_header.php'); ?>

<div class="content">
    <h1>Ranks</h1>
    <div class="rank-item" id="unranked">

        <h2>Unranked</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/unranked.png'); ?>" alt="unranked">

        <p>Not ranked</p>
    </div>
    <div class="rank-item" id="novice">
        <h2>Novice</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/novice.png'); ?>" alt="novice">

        <p>TODO</p>
    </div>
    <div class="rank-item" id="apprentice">
        <h2>Apprentice</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/apprentice.png'); ?>" alt="apprentice">

        <p>TODO</p>
    </div>
    <div class="rank-item" id="adept">
        <h2>Adept</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/adept.png'); ?>" alt="adept">

        <p>TODO</p>
    </div>
    <div class="rank-item" id="expert">
        <h2>Expert</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/expert.png'); ?>" alt="expert">

        <p>TODO</p>
    </div>
    <div class="rank-item" id="master">
        <h2>Master</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/master.png'); ?>" alt="master">

        <p>TODO</p>
    </div>


</div>

<?php include_once(SHARED_PATH . '/student_footer.php'); ?>