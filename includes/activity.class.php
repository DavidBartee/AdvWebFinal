<?php
class Activity {
    public $id;
    public $name;
    public $street;
    public $state;
    public $city;
    public $postal;
    public $activityType;
    public $description;
    public $images;

    function __construct ($i, $n, $s, $st, $c, $d, $p) {
        $this->id = $i;
        $this->name = $n;
        $this->street = $s;
        $this->state = $st;
        $this->city = $c;
        $this->postal = $p;
        $this->description = $d;
        //$this->$images = $imgs;
    }

    public function __toString() {
        return 'name: ' . $this->name . ' street: ' . $this->street;
    }
}
?>