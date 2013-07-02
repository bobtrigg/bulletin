<?php
#  item_validate.inc.php
#  This include file contains validation code for bulletin item entry fields
#  It checks to see that all required data was entered and that all entered data is valid.

function validate_item($dbc,$name,$required,$numeric) {

	global $errors;

	if (isset($_POST[$name]) && (!is_null($_POST[$name])) && ($_POST[$name] != '')) {
	
		$value = mysqli_real_escape_string($dbc, trim($_POST[$name]));
		
	} else {
		if ($required) {
			$errors[] = 'You must enter a ' . $name;
		}
		$value = "";
	}
	
	if ($numeric && (!is_numeric($value) || $value < 0)) {
		$errors[] = $name . " must be numeric and > 0";
	}
	
	return $value;
}

function validate_all_items($dbc) {

	$item = new Item();
	
	$item->set_value('title', validate_item($dbc,'title',true,false));
	$item->set_value('subtitle', validate_item($dbc,'subtitle',false,false));
	$item->set_value('content', validate_item($dbc,'content',true,false));
	$item->set_value('excerpt', validate_item($dbc,'excerpt',true,false));
	$item->set_value('bulletin_date', validate_item($dbc,'bulletin_date',true,false));
	$item->set_value('position', validate_item($dbc,'position',true,true));
	
	return $item;
}
?>
