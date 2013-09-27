<?php
require_once('_includes/opening_housekeeping.inc.php');

// Item ID must be provided!
if (isset($_GET['id'])) {
	$item_id = $_GET['id'];
} else {

	if (!headers_sent($filename, $linenum)) {
		header("Location: list_items.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bob@marinbike.org\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}	
}

//  Get data for specified primary key
if (!$return_row = Table::select_by_unique_key($dbc, 'items', 'item_id', $item_id)) {
	die("Could not access item data" . mysqli_error($dbc));
}

//  Insert data into Item object
$item_object = new Item();
for ($i=0; $i<$item_object->get_col_array_count(); $i++) {
	$field_name = $item_object->get_col_name($i);
	$item_object->set_value($field_name, $return_row[$field_name]);
}

//  New item should not be approved
$item_object->set_value('approved',false);

//  Create new row with copied data
$item_id = $item_object->insert_row($dbc);

//  Go to page to edit new duplicated row
if (!headers_sent($filename, $linenum)) {
	header("Location: edit_item.php?id=" . $item_id);
	exit();
} else {
	die ( "Headers already sent in $filename on line $linenum<br>\n" .
		  "Please report the above information to your <a href=\"mailto:bob@marinbike.org\">system administrator</a>.<br>\n" .
		  "<a href=\"login.php\">Click here</a> to re-login\n");
}	
	
?>