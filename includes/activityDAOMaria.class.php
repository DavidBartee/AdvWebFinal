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

        public function updateActivity ($object) {
            $sql = 'UPDATE activity SET
                name="' . $object->name . '",
                street="' . $object->street . '",
                description="' . $object->description . '",
                state="' . $object->state . '",
                city="' . $object->city . '",
                postal=' . $object->postal . '
                WHERE activityID = ' . $object->id;
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
        }

        public function createActivity ($object) {
            $sql = 'INSERT INTO activity
                        (name, street, description, state, city, postal)
                        VALUES ("' . $object->name . '", "' .
                        $object->street . '", "' .
                        $object->description . '", "' .
                        $object->state . '", "' .
                        $object->city . '", "' .
                        $object->postal . '")';
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
        }

        public function deleteActivity ($id) {
            $sql = 'DELETE FROM activity WHERE activityID = ' . $id;
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
        }
    }
?>