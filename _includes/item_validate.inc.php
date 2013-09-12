<?php
#  item_validate.inc.php
#  This include file contains validation code for bulletin item entry fields
#  It checks to see that all required data was entered and that all entered data is valid.

require_once('_includes/functions.inc.php'); 

function validate_item($dbc,$name,$required=false,$numeric=false,$date=false) {

	global $errors;

	if (isset($_POST[$name]) && (!is_null($_POST[$name])) && ($_POST[$name] != '')) {
	
		$value = nl2br(mysqli_real_escape_string($dbc, trim($_POST[$name])));
		
	} else {
		if ($required) {
			$errors[] = 'You must enter a(n) ' . $name;
		}
		$value = "";
	}
	
	if ($numeric && (!is_numeric($value) || $value < 0)) {
		$errors[] = $name . " must be numeric and > 0";
	}
	
	if ($date) {
		$value = valid_date($value);
		
		if (!$value) {
			$errors[] = "Date is not valid; must be mm/dd/yyyy";
			$value = NULL;
		}
	}
	
	return $value;
}

function validate_all_items($dbc) {

	$item = new Item();
	
	$item->set_value('title', validate_item($dbc,'title',true));
	$item->set_value('subtitle', validate_item($dbc,'subtitle',false));
	$item->set_value('content', validate_item($dbc,'content',true));
	$item->set_value('excerpt', validate_item($dbc,'excerpt',true));
	
	$bulletin_date = ($value = validate_item($dbc,'bulletin_date',true,false,true)) ? $value->format('Y-m-d') : NULL;
	$item->set_value('bulletin_date', $bulletin_date);
	$item->set_value('position', validate_item($dbc,'position',true,true));
	
	//  Code note: setting $bulletin_date MUST precede setting $graphic, $large_graphic, and $thumbnail
	$graphic = validate_item($dbc,'graphic',false);
	$item->set_value('graphic', $graphic);

	$large_graphic = validate_item($dbc,'large_graphic',false);
	$item->set_value('large_graphic', $large_graphic);

	$thumbnail = validate_item($dbc,'thumbnail',false);
	$item->set_value('thumbnail', $thumbnail);

	//  graphic validation must precede alt_text validation 
	if ($item->get_value('graphic') != NULL && $item->get_value('graphic') != '' && $item->get_value('graphic') != ' ') {
		$item->set_value('alt_text', validate_item($dbc,'alt_text',true));
	} else {
		$item->set_value('alt_text', validate_item($dbc,'alt_text',false));
	}
	
	return $item;
}
# The following function's use has been replaced by a parameter
# which can be set in the runtime_parms.inc.php file.
# It's saved here in case a need arises for it in the future.

function set_image_path($filename, $bulletin_date) {

	// Derive full path to image file
	
	if (is_null($bulletin_date)) {
		$year = date('Y');
	} else {
		$year = substr($bulletin_date,0,4);
	}

	if (preg_match('/\//',$filename)) {
		$image_path = $filename;
	} else {
		$image_path = "Images/" . $year . "/" . $filename;
	}
	
	return $image_path;
}
?>
