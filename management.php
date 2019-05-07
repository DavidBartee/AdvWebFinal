<?php
    require_once('config.php');
    include_once('includes/activity.class.php');
    include_once('includes/image.class.php');
    include_once('includes/activityDAO.class.php');
    include_once('includes/activityDAOMaria.class.php');

    include 'includes/mgmt_header.php';

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

    if (isset($_POST['submitCreate'])) {
        global $actDAO;
        $newActivity = new Activity (null,
        $_POST['name'],
        $_POST['street'],
        $_POST['state'],
        $_POST['city'],
        $_POST['description'],
        $_POST['postal']);
        $actDAO->createActivity($newActivity);
    } else if (isset($_POST['submitDelete'])) {
        global $actDAO;
        $actDAO->deleteActivity($_POST['id']);
    } else if (isset($_POST['submitFinishedUpdate'])) {
        global $actDAO;
        $updatedActivity = new Activity ($_POST['id'],
        $_POST['name'],
        $_POST['street'],
        $_POST['state'],
        $_POST['city'],
        $_POST['description'],
        $_POST['postal']);
        $actDAO->updateActivity($updatedActivity);
    }
?>

<ul>
    <li><a href="management.php?mode=create"><strong>Create</strong></a></li>
    <li><a href="management.php"><strong>Read</strong></a></li>
</ul>

<?php
     if(isset($_POST['submitUpdate'])) {
        $toUpdate;
        foreach ($activities as $value) {
            if ($value->id == $_POST['id']) {
                $toUpdate = $value;
                break;
            }
        }
        echo '<h2>Add an Activity</h2>
                <form method="post">
                    <input type="hidden" name="id" value="' . $toUpdate->id . '">
                    <label for="name">Activity Name</label>
                    <input type="text" name="name" id="name" value="' . $toUpdate->name . '">
                    <br/>
                    <label for="street">Street Address</label>
                    <input type="text" name="street" id="street" value="' . $toUpdate->street . '">
                    <br/>
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" value="' . $toUpdate->description . '">
                    <br/>
                    <label for="state">State</label>
                    <input type="text" name="state" id="state" value="' . $toUpdate->state . '">
                    <br/>
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" value="' . $toUpdate->city . '">
                    <br/>
                    <label for="postal">Zip Code</label>
                    <input type="text" name="postal" id="postal" value="' . $toUpdate->postal . '">
                    <br/>
                    <input type="submit" name="submitFinishedUpdate" value="Update">
                </form><br/>';
    } else if (isset($_GET['mode'])) {
        if ($_GET['mode'] == "create") {
            echo '<h2>Add an Activity</h2>
                <form method="post">
                    <label for="name">Activity Name</label>
                    <input type="text" name="name" id="name">
                    <br/>
                    <label for="street">Street Address</label>
                    <input type="text" name="street" id="street">
                    <br/>
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description">
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
                    <input type="submit" name="submitCreate" value="Create">
                </form><br/>';
        }
    }
    //After above form is displayed (if applicable), display all activities for read
    echo '<div class="readContainer">';
    foreach ($activities as $value) {
        echo '<div class="readActivity">
                <h3>' . $value->name . '</h3>
                <p>Description: ' . $value->description . '</p>
                <p>Street: ' . $value->street . '<br/>
                State: ' . $value->state . '<br/>
                City: ' . $value->city . '<br/>
                Zip: ' . $value->postal . '</p>
                <form method="post">
                    <input type="hidden" name="id" value="' . $value->id . '">
                    <input type="submit" name="submitUpdate" value="Update">
                </form>
                <form method="post">
                    <input type="hidden" name="id" value="' . $value->id . '">
                    <input type="submit" name="submitDelete" value="Delete">
                </form>
            </div>';
    }
    echo '</div>';
?>

<?php include 'includes/mgmt_footer.php'; ?>