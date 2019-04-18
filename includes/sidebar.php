<?php
    function compareActivities ($a, $b) {
        return strcmp($a->name, $b->name);
    }

    $alphabetical = $activities;
    usort($alphabetical, "compareActivities");
?>

<div class="sidebar">
    <h1>Concord Attractions</h1>

    <h2>Browse by Category</h2>
    <ul>
        <?php
            

            $allTypes = NULL;
            foreach ($activities as $value) {
                if ($allTypes == NULL || !in_array($value->activityType, $allTypes)) {
                    $allTypes[] = $value->activityType;
                }
            }
            foreach ($allTypes as $value) {
                echo '<li><a href="midterm.php?activityType=' . $value . '">' . $value . '</a></li>';
            }
        ?>
    </ul>

    <h2>Browse by attraction</h2>
    <ul>
        <li><a href="midterm.php">Home</a></li>
        <?php
            foreach ($alphabetical as $value) {
                echo '<li><a href="midterm.php?activity=' . $value->id . '">' . $value->name . '</a></li>';
            }
        ?>
    </ul>
</div>