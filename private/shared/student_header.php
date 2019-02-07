<?php 
    if(!isset($page_title)) {$page_title = 'Student';}
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>MyMakerSite - <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="<?php echo url_for('/style/student.css');?>">
</head>

<body>
    <nav>
        <ul>
            <li><a href="<?php echo url_for('/index.php'); ?>">Public Index</a></li>
            <li><a href="<?php echo url_for('/student/index.php'); ?>">Leaderboard</a></li>
            <li><a href="<?php echo url_for('/student/profile.php'); ?>">Profile</a></li>
            <li><a href="<?php echo url_for('/student/ranks.php'); ?>">Ranks</a></li>
            <li><a href="<?php echo url_for('/student/progress.php'); ?>">Progress</a></li>
        </ul>
    </nav>