<?php
    function compareActivities ($a, $b) {
        return strcmp($a->name, $b->name);
    }

    function compareTypes ($a, $b) {
        return strcmp($a, $b);
    }

    $alphabetical = $activities;
    usort($alphabetical, "compareActivities");
    $allTypes = $types;
    usort($allTypes, "compareTypes");
?>

<div class="sidebar">
    <h1>Concord Attractions</h1>
    <div class="dropdown" style="float:left;">
        <button class="dropbtn">Categories</button>
        <div class="dropdown-content" style="left:0;">
            <?php

            foreach ($activities as $value) {
                if ($allTypes == NULL || !in_array($value->activityType, $allTypes)) {
                    $allTypes[] = $value->activityType;
                }
            }
            foreach ($allTypes as $value) {
                echo '<a href="midterm.php?activityType=' . $value . '">' . $value . '</a>';
            }
            ?>
        </div>

    </div>
    <div class="dropdown" style="float:left;">
        <button class="dropbtn">Attractions</button>
        <div class="dropdown-content" style="left:0;">
            <?php
            foreach ($alphabetical as $value) {
                echo '<a href="midterm.php?activity=' . $value->id . '">' . $value->name . '</a>';
            }
            ?>
        </div>

    </div>
</div>

