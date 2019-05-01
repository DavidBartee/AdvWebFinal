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
<!--    <link rel="stylesheet" href="css/styles.css">-->
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/scripts.js"></script>
</head>

<body>
<?php include 'includes/sidebar.php'; ?>

<!--    async activity display-->
    <div class="container" id="activityDisplay">
        <script>
            let activityIsset = '';
            let activityGet = '';
            activityIsset = <?php echo (isset($_GET['activity']));?>;
            activityGet = <?php echo $_GET['activity']; ?>;

            displayActivity(activityIsset, activityGet);
            // $(function () {
            //     displayActivity(activityIsset, activityGet);
            // });

            $(function () {
                //image ajax call
                var imageData = '';

                $(document).ready(function() {
                    $.ajax({
                        type: "GET",
                        data: {
                            "activityDisplay": $('#activityDisplay').val()
                        },
                        url: "http://localhost/AdvWebFinal/webservice.php?infoType=image",
                        dataType: "json",
                        success: function (JSONObject) {
                            var activityHTML = "";


                            //loop through object
                            for(var key in JSONObject) {
                                if (JSONObject.hasOwnProperty(key)) {

                                    if (activityIsset){
                                        if (JSONObject[key]["id"] == activityGet) {
                                            imageData = '<img src="' + JSONObject[key]["filePath"] + '" alt="' + JSONObject[key]["altText"] + '"/>';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });

                //activity ajax call
                $(document).ready(function() {
                    $.ajax({
                        type: "GET",
                        data: {
                            "activityDisplay": $('#activityDisplay').val()
                        },
                        url: "http://localhost/AdvWebFinal/webservice.php?infoType=activity",
                        dataType: "json",
                        success: function (JSONObject) {
                            var activityHTML = "";


                            //loop through object
                            for(var key in JSONObject) {
                                if (JSONObject.hasOwnProperty(key)) {

                                    if (activityIsset){
                                        if (JSONObject[key]["id"] == activityGet) {
                                            //activityHTML += '<p>' + JSONObject[key]["name"] + '</p>';
                                            activityHTML += '<div class="activity-box">';
                                            activityHTML += '<h2>' + JSONObject[key]["name"] + '</h2>';
                                            activityHTML += imageData; //image
                                            activityHTML += '<h3 style="background-color: white">Location: ' + JSONObject[key]["street"] + ', ' + JSONObject[key]["city"] + ', ' + JSONObject[key]["state"] + ', ' + JSONObject[key]["postal"] + '</h3>';
                                            activityHTML += '<p style="background: white">' + JSONObject[key]["description"] + '</p>';
                                            activityHTML += ''; //session button
                                            activityHTML += '</div>';
                                        }
                                    }
                                }
                            }

                            //insert activity into html
                            $('#activityDisplay').html(activityHTML);
                        }
                    });
                });
            });
        </script>
    </div>

    <div class="container">

        

        <?php
            if (isset($activities)) {
                $foundGet = FALSE;
                if (isset($_GET['activity']) && $_GET['activity'] != NULL) {
                    $foundGet = TRUE;
                }
                $foundSession = FALSE;
                if (isset($_SESSION['activityID']) && $_SESSION['activityID'] != NULL) {
                    $foundSession = TRUE;
                }
                if ($foundGet || $foundSession) {
                    if ($foundGet)
                        $useID = $_GET['activity'];
                    else if ($foundSession)
                        $useID = $_SESSION['activityID'];
                    $_SESSION['activityID'] = $useID;
                    $wasFound = FALSE;
                    foreach ($activities as $value) {
                        if ($value->id == $useID) {
                            $wasFound = TRUE;
                            break;
                        }
                    }
                    if ($wasFound) {
                        echo '<div class="activity-box">
                            <h2>' . $activities[$useID]->name . '</h2>
                            <img src="' . $activities[$useID]->images[0]->filePath . '" alt="' . $activities[$useID]->images[0]->altText . '"/>
                            <h3>Location: ' . $activities[$useID]->street . ', ' . $activities[$useID]->city . ', ' . $activities[$useID]->state . ' ' . $activities[$useID]->postal . '</h3>
                            <p>' . $activities[$useID]->description . '</p>';
                        if ($foundSession) {
                            echo '<button id="sessionReset">Reset Session Data</button>
                                <script language="javascript" type="text/javascript">
                                    $("#sessionReset").click( function () {
                                        if (!(typeof (localStorage) === "undefined" && !typeof (sessionStorage) === "undefined")) {
                                            sessionStorage.clear();
                                            localStorage.clear();
                                            document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                                        }
                                    }
                                    );
                                </script>';
                            }
                        echo '</div>';
                    }
                } else if (isset($_GET['activityType']) && $_GET['activityType'] != NULL) {
                    $numFound = 0;
                    foreach ($activities as $value) {
                        $useID = $value->id;
                        if ($value->activityType == $_GET['activityType']) {
                            echo '<div class="activity-box-small">
                                    <a href="midterm.php?activity=' . $value->id . '">
                                    
                                        <h2>' . $activities[$useID]->name . '</h2>
                                        <img src="' . $activities[$useID]->images[0]->filePath . '" alt="' . $activities[$useID]->images[0]->altText . '"/>
                                    </a>
                                </div>';
                            $numFound++;
                        }
                    }
                } else {

                }
            }
        ?>
    </div>
</body>
</html>