<?php
class Activity {
    public $id;
    public $name;
    public $address;
    public $activityType;
    public $description;
    public $images;

    function __construct ($i, $n, $a, $t, $d) {
        $this->id = $i;
        $this->name = $n;
        $this->address = $a;
        $this->activityType = $t;
        $this->description = $d;
        //$this->$images = $imgs;
    }

    public function __toString() {
        return 'name: ' . $this->name . ' address: ' . $this->address;
    }
}
?>