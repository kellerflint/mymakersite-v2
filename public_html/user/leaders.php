<?php require_once '../../private/initialize.php'; ?>
<?php require_permission(VWR); ?>
<?php 
$page_title = 'Leaderboard';
$page_style = 'leaderboard'; 
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<div class="content">

    <h2>Leaderboard</h2>

    select User.user_first, Rank.rank_title, Maxrank.Maxrank from User inner join
    (select User_Rank.user_id, max(Rank.rank_level) as Maxrank from Rank
    inner join User_Rank on User_Rank.rank_id = Rank.rank_id
    inner join User_Session on User_Session.user_id = User_Rank.user_id
    where User_Session.session_id = 1 and Rank.session_id = 1
    group by user_id) Maxrank on User.user_id = Maxrank.user_id
    inner join User_Rank on User.user_id = User_Rank.user_id
    inner join Rank on User_Rank.rank_id = Rank.rank_id
    where Rank.rank_level = Maxrank.Maxrank;

    */

</div>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>