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
                <!--If role is student show these links-->
                <?php if (check_role_access(STU)) { ?>
                <li><a href="<?php echo url_for('/student/index.php'); ?>">Leaderboard</a></li>
                <li><a href="<?php echo url_for('/student/profile.php'); ?>">Profile</a></li>
                <li><a href="<?php echo url_for('/student/ranks.php'); ?>">Ranks</a></li>
                <li><a href="<?php echo url_for('/student/progress.php'); ?>">Progress</a></li>
                <?php } ?>
                <?php if (check_role_access(INS)) { ?>
                <!--If role is instructor/admin show these links-->
                <li class="instructor"><a href="<?php echo url_for('/instructor/add_user.php'); ?>">Add User</a></li>
                <li class="instructor"><a href="<?php echo url_for('/instructor/give_badge.php'); ?>">Give Badge</a>
                </li>
                <li class="instructor"><a href="<?php echo url_for('/instructor/give_rank.php'); ?>">Give Rank</a></li>
                <?php } ?>
                <?php if (check_role_access(ADM)) { ?>
                <!--If role is admin show these-->
                <li class="admin"><a href="<?php echo url_for('/admin/add_badge.php'); ?>">Add Badge</a></li>
                <?php } ?>
                <!--Always show these-->
                <li><a href="<?php echo url_for('/logout.php'); ?>">Logout</a></li>
                <li><a href="">User: <?php echo $_SESSION['username'] ?? ''; ?></a></li>
            </ul>
        </nav>