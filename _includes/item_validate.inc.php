<?php
#  item_validate.inc.php
#  This include file contains validation code for bulletin item entry fields
#  It checks to see that all required data was entered and that all entered data is valid.

require_once('_includes/functions.inc.php'); 
$image_folder;

function validate_item($dbc,$name,$required=false,$type='text') {

	global $errors;
	global $image_folder;

	if (isset($_POST[$name]) && (!is_null($_POST[$name])) && ($_POST[$name] != '')) {
	
		$value = nl2br(mysqli_real_escape_string($dbc, trim($_POST[$name])));
		
	} else {
		if ($required) {
			$errors[] = 'You must enter a(n) ' . $name;
		}
		$value = "";
	}
	
	if ($type == 'numeric' && (!is_numeric($value) || $value < 0)) {
		$errors[] = $name . " must be numeric and > 0";
	}
	
	if ($type == 'date') {
		$value = valid_date($value);
		
		if (!$value) {
			$errors[] = "Date is not valid; must be mm/dd/yyyy";
			$value = NULL;
		}
	}
	
	if ($type == 'graphic') {
	
		if ($value != $image_folder) {
			if ($value && $value != "jpg" && $value != "gif" && $value != "png") {
				$errors[] = "Graphic (inline or thumbnail) must be a .gif, .jpg, or .png";
			}
		}
	}
	
	return $value;
}

function clear_default_folder_from_graphic($field_value, $image_folder_name) {
		
	if ($field_value == $image_folder_name) {
		$field_value = '';
	}
	return $field_value;
}

function validate_all_items($dbc) {

	global $image_folder;

	$item = new Item();
	
	$item->set_value('title', validate_item($dbc,'title',true));
	$item->set_value('subtitle', validate_item($dbc,'subtitle',false));
	$item->set_value('content', validate_item($dbc,'content',true));
	$item->set_value('excerpt', validate_item($dbc,'excerpt',true));
	
	$bulletin_date = ($wb_date = validate_item($dbc,'bulletin_date',true,'date')) ? $wb_date->format('Y-m-d') : NULL;
	$item->set_value('bulletin_date', $bulletin_date);
	$item->set_value('position', validate_item($dbc,'position',true,'numeric'));
	
	//  Code note: setting $bulletin_date MUST precede setting $graphic, $large_graphic, and $thumbnail
	
	//  $image_folder is default image folder
	//  An equal graphic value indicates no entry and should be blanked with clear_default_folder_from_graphic
	$image_folder = parse_date_string(IMAGE_FOLDER,$wb_date);
	
	$item->set_value('graphic', validate_item($dbc,'graphic',false,'graphic'));
	$item->set_value('graphic', clear_default_folder_from_graphic($item->get_value('graphic'), $image_folder));

	$item->set_value('large_graphic', validate_item($dbc,'large_graphic',false));
	$item->set_value('large_graphic', clear_default_folder_from_graphic($item->get_value('large_graphic'), $image_folder));

	$item->set_value('thumbnail', validate_item($dbc,'thumbnail',false,'graphic'));
	$item->set_value('thumbnail', clear_default_folder_from_graphic($item->get_value('thumbnail'), $image_folder));

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
