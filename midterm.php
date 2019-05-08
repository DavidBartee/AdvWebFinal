<?php
require_once('config.php');
include_once('includes/activity.class.php');
include_once('includes/image.class.php');
include_once('includes/activityDAO.class.php');
include_once('includes/activityDAOMaria.class.php');

session_start();

function resetSession() {
    unset($_SESSION['activityID']);
}

$activities;
$images;
$types;

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

function getTypes () {
    global $actDAO;
    global $pdo;
    try {
        return $actDAO->getActivityTypes($pdo);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

$activities = getActivities();
$types = getTypes();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Concord Attractions</title>
    <link rel="stylesheet" href="css/styles.css">
<!--    <link rel="stylesheet" href="css/bootstrap-4.3.1-dist/css/bootstrap.css"-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/scripts.js"></script>
</head>

<body>
<?php include 'includes/sidebar.php'; ?>

<!--    async activity display-->
    <div class="container" id="activityDisplay">
        <script>
            $(function () {
                let activityArray = [];

                let activityIsset = '';
                let activityGet = '';
                let teamIsset = '';
                let teamGet = '';

                activityIsset = <?php echo (isset($_GET['activity']));?>;
                activityGet = <?php echo $_GET['activity']; ?>;
                teamIsset = <?php echo (isset($_GET['Team'])); ?>;
                teamGet = <?php echo $_GET['Team']; ?>;

                if (teamGet) {
                    if (teamGet == 'ourTeam') {
                        displayActivity(activityIsset, activityGet);
                    }
                    if (teamGet == 'otherTeam'){
                        displayOtherTeam(activityIsset, activityGet);
                    }
                //other team display


                //home page

                //load activities
                //activityArray = loadActivities();

            });
        </script>
    </div>

    <div class="container">

        

<!--        --><?php
//            if (isset($activities)) {
//                $foundGet = FALSE;
//                if (isset($_GET['activity']) && $_GET['activity'] != NULL) {
//                    $foundGet = TRUE;
//                }
//                $foundSession = FALSE;
//                if (isset($_SESSION['activityID']) && $_SESSION['activityID'] != NULL) {
//                    $foundSession = TRUE;
//                }
//                if ($foundGet || $foundSession) {
//                    if ($foundGet)
//                        $useID = $_GET['activity'];
//                    else if ($foundSession)
//                        $useID = $_SESSION['activityID'];
//                    $_SESSION['activityID'] = $useID;
//                    $wasFound = FALSE;
//                    foreach ($activities as $value) {
//                        if ($value->id == $useID) {
//                            $wasFound = TRUE;
//                            break;
//                        }
//                    }
//                    if ($wasFound) {
//                        echo '<div class="activity-box">
//                            <h2>' . $activities[$useID]->name . '</h2>
//                            <img src="' . $activities[$useID]->images[0]->filePath . '" alt="' . $activities[$useID]->images[0]->altText . '"/>
//                            <h3>Location: ' . $activities[$useID]->street . ', ' . $activities[$useID]->city . ', ' . $activities[$useID]->state . ' ' . $activities[$useID]->postal . '</h3>
//                            <p>' . $activities[$useID]->description . '</p>';
//                        if ($foundSession) {
//                            echo '<button id="sessionReset">Reset Session Data</button>
//                                <script language="javascript" type="text/javascript">
//                                    $("#sessionReset").click( function () {
//                                        if (!(typeof (localStorage) === "undefined" && !typeof (sessionStorage) === "undefined")) {
//                                            sessionStorage.clear();
//                                            localStorage.clear();
//                                            document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
//                                        }
//                                    }
//                                    );
//                                </script>';
//                            }
//                        echo '</div>';
//                    }
//                } else if (isset($_GET['activityType']) && $_GET['activityType'] != NULL) {
//                    $numFound = 0;
//                    foreach ($activities as $value) {
//                        $useID = $value->id;
//                        if ($value->activityType == $_GET['activityType']) {
//                            echo '<div class="activity-box-small">
//                                    <a href="midterm.php?activity=' . $value->id . '">
//
//                                        <h2>' . $activities[$useID]->name . '</h2>
//                                        <img src="' . $activities[$useID]->images[0]->filePath . '" alt="' . $activities[$useID]->images[0]->altText . '"/>
//                                    </a>
//                                </div>';
//                            $numFound++;
//                        }
//                    }
//                } else {
//
//                }
//            }
//        ?>
    </div>
</body>
</html>