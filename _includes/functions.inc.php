<?php
// functions.php
// includes functions for Automated Bulletin

function valid_date($date_str) {

#  Checks entered date for valid format.
#  Date is requested in mm/dd/yyyy format
#  If user enters a 2 digit year, will convert to 4 digit
#  Returns date (with 4 digit year), or false if invalid

	//  Initialize errors array
	$errors = array();
	
	//  Make sure date was entered
	if ($date_str == '') {
		$errors[] = 'Event date entry is required';
	}
	
	list($month,$day,$year) = explode('/', $date_str);
	
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
		return $month . "/" . $day . "/" . $year;
		
	} else {
		
		// Entry is incorrect, return errors array
		return false;
	}
}
function db_format_date($date) {     //   yyyymmdd -> yyyy-mm-dd

#  Converts a date in yyyymmdd format to a YYYY-MM-DD format for database insertion and retrieval
#  Returns reformated date

	#####  Get date components
	$year = substr($date, 0,4);
	$month = substr($date, 4,2);
	$day = substr($date, 6,2);

	#####  Reformat using components
	
	return $year . "-" . $month . "-" . $day;
}
function number_format_date($date) {    //  mm/dd/yyyy -> yyyymmdd

#  Converts a date in mm/dd/yyyy format to a yyyymmdd format 
#  Returns reformated date

	#####  Get date components
	list($month,$day,$year) = explode('/',$date);
	
	if (strlen($month) == 1) {
		$month = '0' . $month;
	}
	if (strlen($day) == 1) {
		$day = '0' . $day;
	}

	#####  Reformat using components
	
	return $year . $month . $day;
}
function getstamp($date) {

#  Converts date in YYYYMMDD format to a timestamp and returns timestamp

	#####  Get date components
	$year = substr($date, 0,4);
	$month = substr($date, 4,2);
	$day = substr($date, 6,2);

	#####  Return timestamp using date components
	
	return mktime(0,0,1,$month,$day,$year);
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
function display_date($date) {     //  yyyy-mm-dd -> mm/dd/yyyy

#  Converts a date in YYYY-MM-DD format to a friendly format for display
#  Returns reformated date

	#####  Get date components
	list($year,$month,$day) = explode('-',$date);
	
	#####  Reformat using components
	
	//  Cast components to ints to suppress leading zeroes
	$month = (int) $month;
	$day = (int) $day;
	
	return $month . "/" . $day . "/" . $year;
}
?>