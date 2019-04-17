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
                $activities[$row['activityID']] = new Activity ($row['activityID'], $row['name'], $row['address'], $row['activityType'], $row['description']);
            }

            $statement = $this->pdo->prepare('SELECT * FROM image');
            $statement->execute();

            while ($row = $statement->fetch()) {
                $images[$row['activityID']][] = new Image ($row['imageID'], $row['altText'], $row['filePath']);
            }
            
            foreach ($images as $key => $value) {
                $activities[$key]->images = $value;
            }

            return $activities;
        }
    }
?>