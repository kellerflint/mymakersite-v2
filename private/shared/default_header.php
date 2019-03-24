<?php
if (!isset($page_title)) {
    $page_title = 'Untitled';
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

        <?php if (isset($profile_style) && $page_style != '') { ?>
        <link rel="stylesheet" href="<?php echo url_for('/style/profile/' . $profile_style); ?>">
        <?php 
        } ?>

    </head>

    <body>
        <nav>
            <ul>
                <?php if (is_logged_in()){ ?>
                <div class="dropdown">
                    <button class="dropdown-button"><?php echo $_SESSION['user_name'] ?? ''; ?></button>
                    <div class="dropdown-content">
                        <a href="<?php echo url_for("account/sessions.php"); ?>">Sessions</a>
                        <a href="<?php echo url_for('/account/account.php'); ?>">Account</a>
                        <a href="<?php echo url_for('/logout.php'); ?>">Logout</a>
                    </div>
                </div>
                <?php } else { ?>
                <li><a href="<?php echo url_for("index.php"); ?>">Login</a></li>
                <?php } ?>
                <?php if (in_session() && check_permission(VWR)) { ?>
                <li><a href="<?php echo url_for("/user/leaders.php"); ?>">Leaders</a></li>
                <li><a href="<?php echo url_for("/user/progress.php"); ?>">Badges</a></li>
                <li><a href="<?php echo url_for("/user/ranks.php"); ?>">Ranks</a></li>
                <?php } ?>
                <?php if (in_session() && check_permission(PMT)) { ?>
                <li><a class="promoter" href="<?php echo url_for("/promoter/give_badge.php"); ?>">Give Badge</a></li>
                <li><a class="promoter" href="<?php echo url_for("/promoter/give_rank.php"); ?>">Give Rank</a></li>
                <?php } ?>
                <?php if (in_session() && check_permission(MNG)) { ?>
                <li><a class="manager" href="<?php echo url_for("/manager/add_user.php"); ?>">Add User</a></li>
                <?php } ?>
                <?php if (in_session() && (check_permission(MNG) || check_permission(ADM) || check_permission(OWN))) { ?>
                <li><a class="manager-owner-admin"
                        href="<?php echo url_for("/manager/permissions.php"); ?>">Permissions</a>
                </li>
                <?php } ?>
                <?php if (in_session() && check_permission(ADM)) { ?>
                <li><a class="admin" href="<?php echo url_for("/admin/create_badge.php"); ?>">Create Badge</a></li>
                <?php } ?>
            </ul>
        </nav>