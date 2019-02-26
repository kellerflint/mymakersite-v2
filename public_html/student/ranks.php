<?php require_once('../../private/initialize.php'); ?>
<?php require_role(STU); ?>

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

        <p>Student does not have a rank. They are either new to the class or have decided not to participate in the
            rank system.</p>
    </div>
    <div class="rank-item" id="novice">
        <h2>Novice</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/novice.png'); ?>" alt="novice">

        <p>Student understands the basics of Scratch. They can make simple games and animations.</p>
    </div>
    <div class="rank-item" id="apprentice">
        <h2>Apprentice</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/apprentice.png'); ?>" alt="apprentice">

        <p>Student can make games with multiple sprites and interactions. They understand most of the blocks in
            scratch and how to use those blocks to create basic games and animations.</p>
    </div>
    <div class="rank-item" id="adept">
        <h2>Adept</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/adept.png'); ?>" alt="adept">

        <p>Student can make a variety of complex games with many sprites and complex interactions.
            They understand how to use variables, decision logic and all blocks in scratch.
            With time, this rank should be accessible to any student with regular attendance and good effort in class.
        </p>
    </div>
    <div class="rank-item" id="expert">
        <h2>Expert</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/expert.png'); ?>" alt="expert">
        <p>WARNING: Expert is not something every student is going to reach. It is intentionally reserved for
            those who demonstrate ownership of their learning along with exceptional effort, interest and skill with
            coding.
        </p>
        <p>
            Student understands and can effectively apply the complex mechanics of scratch
            including lists, definitions and cloning.
            They demonstrate strong control of variable logic and exceptional use of decision logic.
            They make well thought out design decisions and are independent, capable troubleshooters.
            They are capable doing extremely complex projects involving multi-nested control statements
            and understand the underlying mathematical principles behind Scratch game design.
        </p>
    </div>
    <div class="rank-item" id="master">
        <h2>Master</h2>

        <img class="rank-img" src="<?php echo url_for('/style/img/rank/master.png'); ?>" alt="master">
        <p>You could run the makerspace.</p>
        <p>Use custom CSS to give yourself the Master badge on your profile page. If
            you're really a master, you'll figure it out ;)</p>
        <p>PS: Pinky swear not to give the answer away!</p>
    </div>


</div>

<?php include_once(SHARED_PATH . '/default_footer.php'); ?>