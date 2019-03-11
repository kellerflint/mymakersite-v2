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
                <!--Always show login and user data-->
                <li><a href="<?php echo url_for('/logout.php'); ?>">Logout</a></li>
                <li><a href="">User: <?php echo $_SESSION['username'] ?? ''; ?></a></li>
            </ul>
        </nav>