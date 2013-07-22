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

function resize_picture($graphic, $max_side_len) {

//  Set image height and width

	//  Get raw image dimensions
	$image_size_info = getimagesize($graphic);
	
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
function upload_file($file) {

	// Pass in $_FILES['file_upload'] as an argument
	// Perform error checking on the form parameters
	
	$errors = array();
	
	$upload_errors = array(
		// This array contains upload error codes and their user friendly equivalents.
		// We can use this for reporting errors.
		UPLOAD_ERR_OK => "No errors",
		UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize",
		UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE",
		UPLOAD_ERR_PARTIAL => "Partial upload",
		UPLOAD_ERR_NO_FILE => "No file",
		UPLOAD_ERR_NO_TMP_DIR => "No temporary directory",
		UPLOAD_ERR_CANT_WRITE => "Can't write to disk",
		UPLOAD_ERR_EXTENSION => "File upload stopped by extension"
	);

	
	if(!$file || empty($file) || !is_array($file)) {
	
		// error: nothing uploaded or wrong argument usage
		$errors[] = "No file was uploaded";
		
	} elseif($file['error'] != 0) {
	
		// error: report what PHP says went wrong
		$errors[] = $upload_errors[$file['error']];
		
	} else {
	
		// Set object attributes to the form parameters
		$source_path = $file['tmp_name'];
		$target_path = "Images/2013/" . basename($file['name']);
		$rtn_status = move_uploaded_file($source_path,$target_path);
		if (!$rtn_status) {
			$errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
		}
	}
	return $errors;
}
?>