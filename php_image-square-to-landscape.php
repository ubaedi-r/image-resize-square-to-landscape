<?php

//Source file
$file   = "assets/quote-2.jpeg";
$img 	= true;
$width 	= 650;
$height = 650;

list($width_orig, $height_orig, $type) = getimagesize($file);

$ratio_orig = $width_orig/$height_orig;
  
if (($width/$height) > $ratio_orig) {
    $width 	= $height*$ratio_orig;
}else{
    $height = $width/$ratio_orig;
}

if ($type == IMAGETYPE_JPEG){
   	$img = imagecreatefromjpeg($file);
}elseif ($type == IMAGETYPE_PNG){
   	$img = imagecreatefrompng($file);
}elseif ($type == IMAGETYPE_GIF){
   	$img = imagecreatefromgif($file);
}else{
   	$img = false;
}

if($img){
    //Setting Background
    $img_bg = imagecreatetruecolor(1060, 1060);
    imagecopyresampled($img_bg, $img, 0, 0, 0, 0, 1060, 1060, $width_orig, $height_orig);
   	$img_bg = imagecrop($img_bg, ['x' => 0, 'y' => 205, 'width' => 1060, 'height' => 650]);
   	
    for ($x=1; $x<=50; $x++){
	    imagefilter($img_bg, IMG_FILTER_GAUSSIAN_BLUR,999);
	} 
   	imagefilter($img_bg, IMG_FILTER_SMOOTH,99);
   	imagefilter($img_bg, IMG_FILTER_BRIGHTNESS, 10);

    //Setting Foreground
   	$img_fg = imagecreatetruecolor($width, $height);
   	imagecopyresampled($img_fg, $img, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

    //Merge Images
   	imagecopymerge($img_bg, $img_fg, 215, ceil((650-$height)/2), 0, 0, $width, $height, 100);

    //If image to show 
    header("Content-type: image/png");
   	imagejpeg($img_bg);

    //If image to save to spesific dir
   	// imagejpeg($img_bg, $modified_filename);
   	
    imagedestroy($img_bg);
}else{
    echo "Image format is not supported.";
}
?>