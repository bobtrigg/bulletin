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

function parse_date_string($rawfilename, $wb_date) {

	// This function parses the passed parameter $rawfilename to
	// generate the file name for the online web page bulletin.
	// It uses parameter $wb_date to translate format codes into  date components.
	// $rawfilename is obtained from the FILE_NAME constant defined in runtime_parms.inc.php.
	
	//  Parameters:
	//    String $rawfilename
	//    DateTime $wb_date
	
	$str_array = str_split($rawfilename);
	$formatted_string = "";
	
	for ($i=0;$i<=count($str_array);$i++) {

		if ($str_array[$i] == "%") {
			$i++;
			$formatted_string .= $wb_date->format($str_array[$i]);
		} else {
			$formatted_string .= $str_array[$i];
		}
	}
	
	return $formatted_string;
}
function make_full_url($filepathname) {

	//  Converts a URL relative to current file or root
	//  to a cyberspace friendly, http prefixed URL
	
	$full_pathname = $_SERVER['REQUEST_URI'];
	$file_pos = strpos($full_pathname,'email_bulletin');
	$dir_name = substr($full_pathname, 0, $file_pos-1);
	$converted_name = "http://" . $_SERVER['SERVER_NAME'];
	
	if (substr($filepathname,0,1) == '.') {
	
		$converted_name .= $dir_name;
		
		while (substr($filepathname,0,3) == '../') {
			$filepathname = substr($filepathname,3);
			$converted_name = substr($converted_name, 0, strrpos($converted_name, '/'));
		}
		
		if (substr($filepathname,0,2) == './') {
			$filepathname = substr($filepathname,2);
		}
		
		$converted_name .= '/' . $filepathname;
		
	} else if (substr($filepathname,0,1) == '/') {
		$converted_name .= $filepathname;
	} else if (substr($filepathname,0,4) == 'http') {
		$converted_name = $filepathname;
	} else {
		$converted_name .= $dir_name . '/' . $filepathname;
	}

	return $converted_name;
}
function generate_bookmark($title,$bookmark) {
	
	if ($bookmark != '' && $bookmark != ' ') {
		return $bookmark;
	}

	// Replace quoted single quotes
	$stripped_title = str_replace(array(' ','\'','’'),'',$title);
	
	// Truncate at first double quote
	if ($first_quote_pos = strpos($stripped_title,'"')) {
		$stripped_title = substr($stripped_title,0,$first_quote_pos);
	}
	
	// Truncate at first ampersand character quote ($quot;)
	if ($first_amp_quote_pos = strpos($stripped_title,'&quot;')) {
		$stripped_title = substr($stripped_title,0,$first_amp_quote_pos);
	}
	
	return substr($stripped_title,0,20);
}
function get_entered_values($item_object) {


}

function get_entered_value($field_name,$item_object) {

	//  Returns the user-entered value of $field_name, stripped of quoted quotes
	//  Cleans up oft-repeated code
	
	$raw_value = $item_object->get_value($field_name);

	$line_feeds_removed = str_replace(array('\n','\r'),'',$raw_value);
	
	return fix_quoted_quotes($line_feeds_removed);
}

function get_bulletin_date($unformatted_date) {

	// Since some versions of PHP do not allow an object reference symbol after a new object declaration,
	// this code can't be condensed to one line. Hence, since it's reused, it's now a function. WTF!

	$bulletin_date = new DateTime($unformatted_date);	
	return $bulletin_date->format('n/j/Y');
}


function fix_quoted_quotes($string_with_quotes, $textarea=false) {
	
	#  This function accepts a string and fixes quoting for redisplay
	#  In textareas and text boxes, backslashes must be removed
	#  In a text box, double quotes must be converted to ampersand character notation
	#  Function assumes text box unless textarea is indicated
	
	$fixed_string = preg_replace('/\\\\/','',$string_with_quotes);
	
	if (!$textarea) {
		$fixed_string = preg_replace('/\"/','&quot;',$fixed_string);
	}
	
	return $fixed_string;
}
function fix_control_chars($in_string) {

	//  Replaces pesky control characters which have replaced
	//  some punctuation characters somewhere in the process.
	//  Also remove paragraph tags added to excerpt by tinyMCE

	$out_string = preg_replace('/’/','\'',$in_string);
	$out_string = preg_replace('/<p>/','',$out_string);
	$out_string = preg_replace('/<\/p>/','',$out_string);
	$out_string = preg_replace('/\&quot;/','"',$out_string);
	
	return $out_string;
}
?>