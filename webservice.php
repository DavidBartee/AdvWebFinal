<?php
    require_once('config.php');
    include_once('includes/activity.class.php');
    include_once('includes/image.class.php');
    include_once('includes/activityDAO.class.php');
    include_once('includes/activityDAOMaria.class.php');

    $activities;
    $images;
    $types;

    header('Content-type: application/json');
    
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

    $activitiesArray = [];
    foreach ($activities as $key => $value) {
        array_push($activitiesArray, [
            'id' => $value->id,
            'name' => $value->name,
            'street' => $value->street,
            'state' => $value->state,
            'city' => $value->city,
            'postal' => $value->postal,
            'description' => $value->description
        ]);
    }

    foreach ($activities as $value) {
        foreach ($value->images as $svalue) {
            $images[] = $svalue;
        }
    }

    $imagesArray = [];
    foreach ($images as $key => $value) {
        array_push($imagesArray, [
            'id' => $value->id,
            'altText' => $value->altText,
            'filePath' => $value->filePath
        ]);
    }
    if (isset($_GET['infoType']) && $_GET['infoType'] != NULL) {
        if ($_GET['infoType'] == "activity") {
            echo json_encode($activitiesArray);
        } else if ($_GET['infoType'] == "image") {
            echo json_encode($imagesArray);
        }
    }
?>