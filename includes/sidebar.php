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

<div id="titleBar">

    <img src="images/advWebFinalLogo.png" class="logo" style="float:left;">
    <img src="images/advWebFinalLogo.png" class="logo" style="float:right;">
    <h1 id="pageTitle">Concord Attractions</h1>

    <div id="dropDownBars">

        <div class="dropdown">
            <button class="dropbtn"><a style="text-decoration:none; color: white" href="midterm.php">Home Page</a></button>
        </div>

<!--        <div class="dropdown">-->
<!--            <button class="dropbtn">Categories</button>-->
<!--            <div class="dropdown-content" style="left:0;">-->
<!--                --><?php
//
//                foreach ($activities as $value) {
//                    if ($allTypes == NULL || !in_array($value->activityType, $allTypes)) {
//                        $allTypes[] = $value->activityType;
//                    }
//                }
//                foreach ($allTypes as $value) {
//                    echo '<a href="midterm.php?activityType=' . $value . '">' . $value . '</a>';
//                }
//                ?>
<!--            </div>-->
<!---->
<!--        </div>-->
<!--        <div class="dropdown">-->
<!--            <button class="dropbtn">Attractions</button>-->
<!--            <div class="dropdown-content" style="left:0;">-->
<!--                --><?php
//                foreach ($alphabetical as $value) {
//                    echo '<a href="midterm.php?activity=' . $value->id . '">' . $value->name . '</a>';
//                }
//                ?>
<!--            </div>-->
<!---->
<!--        </div>-->

        <div class="dropdown">
            <button class="dropbtn" id="ourTeamActivityBtn">Activities from web service</button>
            <div class="dropdown-content" style="left:0;" id="webServerDropDown">

            </div>
        </div>

        <div class="dropdown">
            <button class="dropbtn" id="otherTeamActivityBtn">Activities from other team</button>
            <div class="dropdown-content" style="left:0;" id="otherWebServerDropDown">

            </div>
       </div>
    </div>
</div>

