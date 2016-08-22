<?php

/*
 * Page's Script
 */

if (isset($this->css)) {
    foreach ($this->css as $css) {
        echo '<link rel="stylesheet" href="' . URL . 'views/' . $css . '">';
    }
}


if (isset($this->js)) {
    foreach ($this->js as $js) {
        echo '<script type="text/javascript" src="' . URL . 'views/' . $js . '"></script>';
    }
}



/*===================
 * Global Function
 ===================*/
function showFullSQL($array){
    foreach ($array as $key => $value) 
    {
        $sql = str_replace(":{$key}", "'" . $value . "'", $sql);
    }
    echo $sql;
}

//function resizeIMG($pic_post, $pic_name) {
//    $maxScale = 150;
//    $scale = getimagesize("$pic_post/$pic_name");
//    $w = $scale[0];
//    $h = $scale[1];
//    if ($scale[0] > $maxScale || $scale[1] > $maxScale) {
//        if ($w >= $h) {
//            $width = $maxScale;
//            $height = floor(($maxScale / $w) * $h);
//        } else {
//            $width = floor(($maxScale / $h) * $w);
//            $height = $maxScale;
//        }
//        echo "<img src='$pic_post/$pic_name' width='$width' height='$height' title='' border='0'>";
//    } else {
//        echo "<img src='$pic_post/$pic_name' width='$w' height='$h' title='' border='0'>";
//    }
//    return $scale;
//}

?>