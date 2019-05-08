<?php
    require_once('config.php');
    include_once('includes/activity.class.php');
    include_once('includes/image.class.php');
    include_once('includes/activityDAO.class.php');
    include_once('includes/activityDAOMaria.class.php');

    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $actDAO = new ActivityDAOMaria($pdo);

    function getActivities () {
        global $actDAO;
        global $pdo;
        try {
            return $actDAO->getAll($pdo);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    $activities = getActivities();
    $images = array();

    foreach ($activities as $value) {
        if (isset($value->images)) {
            for ($imgcount = 0; $imgcount <= max(array_keys($value->images)); $imgcount++) {
                if ($value->images[$imgcount] == null) {
                    continue;
                }
                $images[] = $value->images[$imgcount];
            }
        }
    }

    if (isset($_POST['submitCreateActivity'])) {
        global $actDAO;
        $newActivity = new Activity (null,
            $_POST['name'],
            $_POST['street'],
            $_POST['state'],
            $_POST['city'],
            $_POST['description'],
            $_POST['postal']);
        $actDAO->createActivity($newActivity);
        resetAndReload();
    } else if (isset($_POST['submitCreateImage'])) {
        global $actDAO;
        $newImage = new Image (null,
            $_POST['altText'],
            $_POST['filePath'],
            $_POST['activityID']);
        $actDAO->createImage($newImage);
        resetAndReload();
    } else if (isset($_POST['submitDeleteActivity'])) {
        global $actDAO;
        $actDAO->deleteActivity($_POST['id']);
        resetAndReload();
    } else if (isset($_POST['submitDeleteImage'])) {
        global $actDAO;
        $actDAO->deleteImage($_POST['id']);
        resetAndReload();
    } else if (isset($_POST['submitFinishedUpdateActivity'])) {
        global $actDAO;
        $updatedActivity = new Activity ($_POST['id'],
            $_POST['name'],
            $_POST['street'],
            $_POST['state'],
            $_POST['city'],
            $_POST['description'],
            $_POST['postal']);
        $actDAO->updateActivity($updatedActivity);
        resetAndReload();
    } else if (isset($_POST['submitFinishedUpdateImage'])) {
        global $actDAO;
        $updatedImage = new Image ($_POST['id'],
            $_POST['altText'],
            $_POST['filePath'],
            $_POST['activityID']);
        $actDAO->updateImage($updatedImage);
        resetAndReload();
    }

    function resetAndReload () {
        $_POST = array();
        header('Location: management.php');        
    }

    include 'includes/mgmt_header.php';
?>

<ul>
    <li><a href="management.php?mode=createActivity"><strong>Create Activity</strong></a></li>
    <li><a href="management.php?mode=createImage"><strong>Create Image</strong></a></li>    
    <li><a href="management.php"><strong>Refresh</strong></a></li>
</ul>

<?php
     if (isset($_POST['submitUpdateActivity'])) {
        $toUpdate;
        foreach ($activities as $value) {
            if ($value->id == $_POST['id']) {
                $toUpdate = $value;
                break;
            }
        }
        echo '<h2>Update Activity</h2>
                <form method="post">
                    <input type="hidden" name="id" value="' . $toUpdate->id . '">
                    <label for="name">Activity Name</label>
                    <input type="text" name="name" id="name" value="' . $toUpdate->name . '">
                    <br/>
                    <label for="street">Street Address</label>
                    <input type="text" name="street" id="street" value="' . $toUpdate->street . '">
                    <br/>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="12" cols="35">' . $toUpdate->description . '</textarea>
                    <br/>
                    <label for="state">State</label>
                    <input type="text" name="state" id="state" value="' . $toUpdate->state . '">
                    <br/>
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" value="' . $toUpdate->city . '">
                    <br/>
                    <label for="postal">Zip Code</label>
                    <input type="text" name="postal" id="postal" value="' . $toUpdate->postal . '">
                    <br/>';
                    echo '<input type="submit" name="submitFinishedUpdateActivity" value="Update">
                </form><br/>';
    } else if (isset($_POST['submitUpdateImage'])) {
        $toUpdate;
        foreach ($images as $value) {
            if ($value->id == $_POST['id']) {
                $toUpdate = $value;
                break;
            }
        }
        $useActivityID;
        foreach ($activities as $value) {
            if ($value->id == $toUpdate->activityID) {
                $useActivityID = $value->id;
                break;
            }
        }
        echo '<h2>Update Image</h2>
                <form id="updateImageForm" method="post">
                    <input type="hidden" name="id" value="' . $toUpdate->id . '">
                    <label for="filePath">File Path/URL</label>
                    <textarea name="filePath" id="filePath" rows="4" cols="35">' . $toUpdate->filePath . '</textarea>
                    <br/>
                    <label for="altText">Alt Text</label>
                    <textarea name="altText" id="altText" rows="4" cols="35">' . $toUpdate->altText . '</textarea>
                    <br/>
                    <label for="activityID">Goes with Activity</label>
                    <select name="activityID" id="activityID" form="updateImageForm" value="' . $useActivityID . '">';
                    for ($counter = 0; $counter <= max(array_keys($activities)); $counter++) {
                        if ($activities[$counter] == null || !isset($activities[$counter])) {
                            continue;
                        }
                        if ($activities[$counter]->id == $toUpdate->activityID) {
                            echo '<option value="' . $activities[$counter]->id . '" selected>' . $activities[$counter]->name . '</option>';
                        } else {
                            echo '<option value="' . $activities[$counter]->id . '">' . $activities[$counter]->name . '</option>';
                        }
                    }
                    echo '</select>';

                    echo '<br/><input type="submit" name="submitFinishedUpdateImage" value="Update">
                </form><br/>';
    } else if (isset($_GET['mode'])) {
        if ($_GET['mode'] == "createActivity") {
            echo '<h2>Add an Activity</h2>
                <form method="post">
                    <label for="name">Activity Name</label>
                    <input type="text" name="name" id="name">
                    <br/>
                    <label for="street">Street Address</label>
                    <input type="text" name="street" id="street">
                    <br/>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="12" cols="35"></textarea>
                    <br/>
                    <label for="state">State</label>
                    <input type="text" name="state" id="state">
                    <br/>
                    <label for="city">City</label>
                    <input type="text" name="city" id="city">
                    <br/>
                    <label for="postal">Zip Code</label>
                    <input type="text" name="postal" id="postal">
                    <br/>
                    <input type="submit" name="submitCreateActivity" value="Create">
                </form><br/>';
        } else if ($_GET['mode'] == "createImage") {
            $firstActivityID = $activities[min(array_keys($activities))]->id;
            echo '<h2>Create an Image</h2>
                <form id="createImageForm" method="post">
                    <label for="filePath">File Path/URL</label>
                    <textarea name="filePath" id="filePath" rows="4" cols="35"></textarea>
                    <br/>
                    <label for="altText">Alt Text</label>
                    <textarea name="altText" id="altText" rows="4" cols="35"></textarea>
                    <br/>
                    <label for="activityID">Goes with Activity</label>
                    <select name="activityID" id="activityID" form="createImageForm" value="' . $firstActivityID . '">';
                    for ($counter = 0; $counter <= max(array_keys($activities)); $counter++) {
                        if ($activities[$counter] == null || !isset($activities[$counter])) {
                            continue;
                        }
                        if ($activities[$counter]->id == $firstActivityID) {
                            echo '<option value="' . $activities[$counter]->id . '" selected>' . $activities[$counter]->name . '</option>';
                        } else {
                            echo '<option value="' . $activities[$counter]->id . '">' . $activities[$counter]->name . '</option>';
                        }
                    }
                    echo '</select>';
                    echo '<input type="submit" name="submitCreateImage" value="Create">
                </form><br/>';
        }
    }
    //After above form is displayed (if applicable), display all activities for read
    echo '<h2 class="sectionHeader">Activities</h2>
    <hr/><div class="readContainer">';
    for ($counter = 0; $counter <= max(array_keys($activities)); $counter++) {
        if (!isset($activities[$counter]) || $activities[$counter] == null) {
            continue;
        }
        echo '<div class="readActivity">
                <h3>' . $activities[$counter]->name . '</h3>
                <p>Description: ' . $activities[$counter]->description . '</p>
                <p>Street: ' . $activities[$counter]->street . '<br/>
                State: ' . $activities[$counter]->state . '<br/>
                City: ' . $activities[$counter]->city . '<br/>
                Zip: ' . $activities[$counter]->postal . '</p>';
        /*for ($i = 0; $i < sizeof($activities[$counter]->images); $i++) {
            echo '<img src="' . $activities[$counter]->images[$i]->filePath . '" alt="' . $activities[$counter]->images[$i]->altText . '/>';
        }*/
        echo '<form method="post">
                <input type="hidden" name="id" value="' . $activities[$counter]->id . '">
                <input type="submit" name="submitUpdateActivity" value="Update">
            </form>
            <form method="post">
                <input type="hidden" name="id" value="' . $activities[$counter]->id . '">
                <input type="submit" name="submitDeleteActivity" value="Delete">
            </form>';
        echo '</div>';
    }//end activity containers
    echo '</div>
    <h2 class="sectionHeader">Images</h2>
    <hr/><div class="readContainer">';
    for ($counter = 0; $counter <= max(array_keys($images)); $counter++) {
        if (!isset($images[$counter]) || $images[$counter] == null) {
            continue;
        }
        echo '<div class="readImage">
            <img src="' . $images[$counter]->filePath . '" alt="' . $images[$counter]->altText . '"/>
            <h4>' . $activities[$images[$counter]->activityID]->name . '</h4>
            <p>File Path: ' . $images[$counter]->filePath . '</p>
            <p>Alt Text: ' . $images[$counter]->altText . '</p>';
        echo '<form method="post">
                <input type="hidden" name="id" value="' . $images[$counter]->id . '">
                <input type="submit" name="submitUpdateImage" value="Update">
            </form>
            <form method="post">
                <input type="hidden" name="id" value="' . $images[$counter]->id . '">
                <input type="submit" name="submitDeleteImage" value="Delete">
            </form>';
        echo '</div>';
    }//end image containers
    echo '</div>';
?>

<?php include 'includes/mgmt_footer.php'; ?>