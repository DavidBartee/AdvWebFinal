<?php
class Image {
    public $id;
    public $altText;
    public $filePath;
    public $activityID;

    function __construct ($i, $a, $f, $aid) {
        $this->id = $i;
        $this->altText = $a;
        $this->filePath = $f;
        $this->activityID = $aid;
    }
}
?>