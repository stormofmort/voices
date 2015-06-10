<?php
	// File and new size
	$filename = "../images/".$_GET['loc']."/".$_GET['file'];
	
	// Get new sizes
	$size = getimagesize($filename);
	
	// Content type
	header("Content-type: {$size['mime']}");

	$percent = $size[1] / 100;
	$newheight = $size[1] / $percent;
	$newwidth = $size[0] / $percent;
	
	// Load
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	if ( $size['mime'] == 'image/jpeg' ) {
		$source = imagecreatefromjpeg($filename);
	} elseif ( $size['mime'] == 'image/png' ) {
		$source = imagecreatefrompng($filename);
	}
	
	// Resize
	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $size[0], $size[1]);
	// Output
	if ( $size['mime'] == 'image/jpeg' ) {
		imagejpeg($thumb);
	} elseif ( $size['mime'] == 'image/png' ) {
		imagepng($thumb);
	}
	
	imagedestroy($thumb);
	imagedestroy($source);
?>