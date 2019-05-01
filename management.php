<?php
    require_once('config.php');
    include_once('includes/activity.class.php');
    include_once('includes/image.class.php');
    include_once('includes/activityDAO.class.php');
    include_once('includes/activityDAOMaria.class.php');

    include 'includes/mgmt_header.php';
?>

<ul>
    <li><a href="create.php"><strong>Create</strong></a></li>
    <li><a href="Read.php"><strong>Read</strong></a></li>
</ul>

<?php include 'includes/mgmt_footer.php'; ?>