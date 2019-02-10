<?php
if (!isset($page_title)) {
    $page_title = 'Student';
}
?>

<!doctype html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>MyMakerSite - <?php echo $page_title; ?></title>
        <link rel="stylesheet" href="<?php echo url_for('/style/default.css'); ?>">
        <?php if (isset($page_style) && $page_style != '') { ?>
        <link rel="stylesheet" href="<?php echo url_for('/style/' . $page_style . '.css'); ?>">
        <?php 
    } ?>

    </head>

    <body>
        <nav>
            <ul>
                <li><a href="<?php echo url_for('/index.php'); ?>">Public Index</a></li>
                <li><a href="<?php echo url_for('/student/index.php'); ?>">Leaderboard</a></li>
                <li><a href="<?php echo url_for('/student/profile.php'); ?>">Profile</a></li>
                <li><a href="<?php echo url_for('/student/ranks.php'); ?>">Ranks</a></li>
                <li><a href="<?php echo url_for('/student/progress.php'); ?>">Progress</a></li>
                <!--If role is instructor/admin show these links-->
                <li class="instructor"><a href="<?php echo url_for('/instructor/add_user.php'); ?>">Add User</a></li>
                <li class="instructor"><a href="<?php echo url_for('/instructor/give_badge.php'); ?>">Give Badge</a>
                </li>
                <li class="instructor"><a href="<?php echo url_for('/instructor/give_rank.php'); ?>">Give Rank</a></li>
                <!--If role is admin show these-->
                <li class="admin"><a href="<?php echo url_for('/instructor/add_badge.php'); ?>">Add Badge</a></li>
            </ul>
        </nav>