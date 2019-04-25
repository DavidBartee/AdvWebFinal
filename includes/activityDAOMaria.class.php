<?php
    class ActivityDAOMaria implements ActivityDAO {

        public $pdo;

        function __construct ($pdo) {
            $this->pdo = $pdo;
        }

        public function getAll () {
            $statement = $this->pdo->prepare('SELECT * FROM activity');
            $statement->execute();
            $activities;

            while ($row = $statement->fetch()) {
                $activities[$row['activityID']] = new Activity ($row['activityID'], $row['name'], $row['street'], $row['state'], $row['city'], $row['description'], $row['postal']);
            }

            $statement = $this->pdo->prepare('SELECT * FROM image');
            $statement->execute();

            while ($row = $statement->fetch()) {
                $images[$row['activityID']][] = new Image ($row['imageID'], $row['altText'], $row['filePath'], $row['activityID']);
            }
            
            foreach ($images as $key => $value) {
                $activities[$key]->images = $value;
            }

            return $activities;
        }

        public function getActivityTypes () {
            $statement = $this->pdo->prepare('SELECT * FROM activityType');
            $statement->execute();
            $types;

            while ($row = $statement->fetch()) {
                $types[$row['typeID']] = $row['typeName'];
            }

            return $types;
        }
    }
?>