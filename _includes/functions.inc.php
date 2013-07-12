<?php
// functions.php
// includes functions for Automated Bulletin

function valid_date($date_str) {  // mm/dd/yyyy -> DateTime object

	#  Checks user-entered date for valid format.
	#  Date is required to be in mm/dd/yyyy format
	#  If user enters a 2 digit year, will convert to 4 digit
	#  Returns DateTime object, or false if invalid

	//  Initialize errors array
	$errors = array();
	
	//  Make sure date was entered
	if ($date_str == '') {
		$errors[] = 'Event date entry is required';
	}
	
	$components = explode('/', $date_str);
	
	if (count($components) < 3) {
		$errors[] = 'Date is not valid (must be mm/dd/yyyy format)';
		return false;
	}

	// list($month,$day,$year) = explode('/', $date_str);
	$month = $components[0];
	$day = $components[1];
	$year = $components[2];
	
	//  Convert string to an array of month, date, year, and use checkdate() to validate
	if (!checkdate($month,$day,$year)) {
		$errors[] = 'Date is not valid (must be mm/dd/yyyy format)';
	}
	
	$iyear = (int)$year;
	
	if ($iyear < 100) {
		$year = ($iyear > 50) ? ($iyear + 1900) : ($iyear + 2000);
	}
	
	if (empty($errors)) {  
	
		// entry passes validation tests; return date type 
		return new DateTime($year . '-' . $month . '-' . $day);
		
	} else {
		
		// Entry is incorrect, return errors array
		return false;
	}
}

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