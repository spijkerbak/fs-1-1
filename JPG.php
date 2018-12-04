<?php

require_once 'File.php';

class JPG extends File {

    private $clip; // array of percentages top, right, bottom, left

    function __construct() {
        $args = func_get_args();
        $last = count($args) - 1;
        $ex = 0;
        if ($last >= 0) {
            $ex = explode(';', $args[$last]);
        }
        if (count($ex) > 1) {
            $args[$last] = $ex[0];
            $this->clip = explode(',', $ex[1]);
            if(count($this->clip) != 4) {
                $this->clip = null;
            }
        } else {
            $this->clip = null;
        }
        parent::__construct($args);
    }

    function getClip() { // return array of 4 or null
        return $this->clip;
    }
    function getimagesize() {
        return getimagesize($this->path);
    }

    function createW($source, $width) {
        list($w, $h, $type, $attr) = $source->getimagesize();
        $neww = $width;
        $newh = $h * $width / $w;
        $srcimage = imagecreatefromjpeg($source->path);
        $dstimage = imagecreatetruecolor($neww, $newh);
        imagecopyresampled($dstimage, $srcimage, 0, 0, 0, 0, $neww, $newh, $w, $h);
        imagejpeg($dstimage, $this->path, 75);
    }

    function createH($source, $height) {
        list($w, $h, $type, $attr) = $source->getimagesize();
        $newh = $height;
        $neww = $w * $height / $h;
        $srcimage = imagecreatefromjpeg($source->path);
        $dstimage = imagecreatetruecolor($neww, $newh);
        imagecopyresampled($dstimage, $srcimage, 0, 0, 0, 0, $neww, $newh, $w, $h);
        imagejpeg($dstimage, $this->path, 75);
    }

    /**
     * Get web-source of image
     * @param int $w : pixel width or 0
     * @param int $h : pixel height or 0
     * @return string : like 'img?src=/Pictures/Birds/GreatTits.jpg&w=300'
     */
    function getSource($w = 0, $h = 0) {
        $relpath = str_ireplace(IMG_ROOT, '', $this->path);

        $src = "http://localhost/image?src={$relpath}";
        if ($w != 0) {
            $src .= "&w={$w}";
        }
        if ($h != 0) {
            $src .= "&h={$h}";
        }
        return $src;
    }


}
