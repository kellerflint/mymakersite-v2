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
                <li><a href="<?php echo url_for("/user/progress.php"); ?>">Progress</a></li>
                <li><a href="<?php echo url_for("/user/ranks.php"); ?>">Ranks</a></li>
                <?php } ?>
            </ul>
        </nav>