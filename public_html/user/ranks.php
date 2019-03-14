<?php require_once('../../private/initialize.php'); ?>
<?php require_permission(VWR); ?>
<?php 
$page_title = 'Ranks';
$page_style = 'ranks';
?>

<?php include_once(SHARED_PATH . '/default_header.php'); ?>

<div class="content">
    <h1>Ranks</h1>
    <div class="rank-item" id="unranked">

        <h2>Unranked</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/unranked.png'); ?>" alt="unranked">

        <p>You are new to the makerspace and learning the basics of Scratch coding.</p>
    </div>
    <div class="rank-item" id="novice">
        <h2>Novice</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/novice.png'); ?>" alt="novice">

        <p>You know how to do the basics in Scratch. You can make simple games and animations on your own.</p>
    </div>
    <div class="rank-item" id="apprentice">
        <h2>Apprentice</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/apprentice.png'); ?>" alt="apprentice">

        <p>You understand how to use most blocks in scratch and how to apply them to make games on your own.</p>
    </div>
    <div class="rank-item" id="adept">
        <h2>Adept</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/adept.png'); ?>" alt="adept">

        <p>You understand all of the blocks in scratch and can use them to create good games on your own.
        </p>
    </div>
    <div class="rank-item" id="expert">
        <h2>Expert</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/expert.png'); ?>" alt="expert">
        <p>
            You have great practical understanding of how coding and block interactions work and you can create any type
            of game you can image on your own.
        </p>
    </div>
    <div class="rank-item" id="master">
        <h2>Master</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/master.png'); ?>" alt="master">
        <p>Is anyone even gonna get this? I’m not even sure if I’ll make it!</p>
    </div>


</div>

<?php include_once(SHARED_PATH . '/default_footer.php'); ?>