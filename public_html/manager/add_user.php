<?php require_once '../../private/initialize.php'; ?>
<?php 
    require_role(MNG);
    $page_title = 'Add User';
    //$page_style = 'give';
?>


<?php include_once SHARED_PATH . '/default_header.php'; ?>

<!--Should double as delete user-->

<!--right side should be list of users in your session, center form box for submit add/remove user,
    left side should be searchable input name [shows names close to the one or max out at 10 closest or something]-->

<!--Also need an edit session metadata page for owners-->

<?php include_once SHARED_PATH . '/default_footer.php'; ?>