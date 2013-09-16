<?php
#  item_validate.inc.php
#  This include file contains validation code for bulletin item entry fields
#  It checks to see that all required data was entered and that all entered data is valid.

require_once('_includes/functions.inc.php'); 
$image_folder;

function validate_item($dbc,$name,$item) {

	global $errors;

	$type = Item::get_type($name);

	if ($name == 'alt_text') {
	
		if ($item->get_value('graphic') != NULL && 
		    $item->get_value('graphic') != '' 	&& 
			$item->get_value('graphic') != ' ') {
				$required = true;
		} else {
				$required = false;
		}
	} else {
		$required = Item::get_required_yn($name);
	}
	
	$wb_date = new DateTime($item->get_value('bulletin_date'));
	$image_folder = parse_date_string(IMAGE_FOLDER,$wb_date);
	
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
		} else {
			$value = $value->format('Y-m-d');
		}
	}
	
	if ($type == 'graphic') {
	
		if ($value == $image_folder) {
			
			$value = '';
			
		} elseif ($name == 'graphic' || $name == 'thumbnail') {
		
			$suffix = substr($value,-3);
			if ($suffix && $suffix != "jpg" && $suffix != "gif" && $suffix != "png") {
				$errors[] = "Graphic (inline or thumbnail) must be a .gif, .jpg, or .png: (" . $name . ", suffix " . $suffix . ")";
			}
		}
	}

	return $value;
}

function validate_all_items($dbc) {

	$item = new Item();
	
	for ($i=0; $i<$item->get_col_array_count(); $i++) {
		$field_name = $item->get_col_name($i);
		$item->set_value($field_name, validate_item($dbc,$field_name,$item));
	}
	
	return $item;
}
?>
