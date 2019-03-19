<?php require_once '../../private/initialize.php'; ?>
<?php 
    require_permission(ADM);
    $page_title = 'Assign Permissions';
    //$page_style = 'give';
?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<div class="content">

    <!-- checkboxes or lists? (like in gives). Same layout as gives though (users left, form center, items right) -->
    <!-- user can't have no permissions. Must be seperate button to delete them from session for clarity. 
    (even thought it would totally work)-->

</div>

<?php include_once SHARED_PATH . '/default_footer.php'; ?>