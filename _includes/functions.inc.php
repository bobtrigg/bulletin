<?php
// functions.php
// includes functions for Automated Bulletin

include_once('classes/date.class.php'); 

function resize_picture($image_link_url, $max_side_len) {

//  Set image height and width

	//  Get raw image dimensions
	$image_size_info = getimagesize($image_link_url);
	
	//  Set dimension values for image
	$width = $image_size_info[0];
	$height = $image_size_info[1];
	
	if ($width > $max_side_len || $height > $max_side_len) {  // Image must be resized
	
		if ($width > $height) {
			$height *= ($max_side_len / $width);
			$width = $max_side_len;
		} else {
			$width *= ($max_side_len / $height);
			$height = $max_side_len;
		}
	}
	return array($width,$height);
}
?>