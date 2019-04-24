<?php
class Image {
    public $id;
    public $altText;
    public $filePath;

    function __construct ($i, $a, $f) {
        $this->id = $i;
        $this->altText = $a;
        $this->filePath = $f;
    }
}
?>