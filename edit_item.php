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

function replace_blank_image_url($url,$date) {

	//  This function sets all image URLs to the default folder, if specified, for ease of entry.

	$date_object = new DateTime($date);
	
	if ($url == '' || $url == ' ') {
		return parse_date_string(IMAGE_FOLDER,$date_object);
	} else {
		return $url;
	}
}

// Obtain previous and next row ids from $_SESSION variable
if ($item_ids = $_SESSION['item_ids']) {
	$curr_item_key = array_search($item_id, $item_ids);
}

// Find previous and next items for navigation
if ($curr_item_key === false) {
	$next_item_id = null;
	$prev_item_id = null;
} else {
	$prev_item_id = ($curr_item_key == 0) ? null : $item_ids[$curr_item_key - 1] ;
	$next_item_id = ($curr_item_key >= count($item_ids) - 1) ? null : $item_ids[$curr_item_key + 1] ;
}

if (isset($_POST['submitted'])) {

	$item_object = validate_all_items($dbc);
	$item_object->set_pk_id($item_id);

	if (empty($errors)) { //  Data is valid
	
		if (empty($errors)) {
	
			//  Update record
			if ($result = $item_object->update_row($dbc)) {
				$_SESSION['message'] = "\nUpdate succeeded";
			} else {
				$_SESSION['message'] = "\nUpdate failed: " . mysqli_error($dbc);
			}
		} else {
			$_SESSION['message'] = "\nFile upload failed; update aborted.";		
		}

		// Go to appropriate page, based on which submit button was clicked.
		if (!headers_sent($filename, $linenum)) {
		
			if ($_POST['submit'] == 'Previous') {
				$location = "edit_item.php?id=" . $prev_item_id;
			} elseif ($_POST['submit'] == 'Next') {
				$location = "edit_item.php?id=" . $next_item_id;
			} else {
				$location = "list_items.php?date=" . preg_replace('/\-/','',$item_object->get_value('bulletin_date'));
			}
			
			header("Location:" . $location);
			exit();
			
		} else {
			die ( "Headers already sent in $filename on line $linenum<br>\n" .
				  "Please report the above information to your <a href=\"mailto:bob@marinbike.org\">system administrator</a>.<br>\n" .
				  "<a href=\"login.php\">Click here</a> to re-login\n");
		}
		

	} else {    //  Reset all values for redisplay after error
	
		for ($i=0; $i<$item_object->get_col_array_count(); $i++) {
			$field_name = $item_object->get_col_name($i);
			$item_object->$field_name = get_entered_value($field_name,$item_object);
		}

		$item_object->bulletin_date = get_bulletin_date($item_object->bulletin_date);
	}
	
}  else {

	$item_object = new Item();

	//  Get data for specified primary key
	if (!$return_row = Table::select_by_unique_key($dbc, 'items', 'item_id', $item_id)) {
		die("Could not access item data" . mysqli_error($dbc));
	}
	
	//  Assign event data to variables
	
	for ($i=0; $i<$item_object->get_col_array_count(); $i++) {
	
		$field_name = $item_object->get_col_name($i);
		$item_object->$field_name = fix_quoted_quotes($return_row[$field_name]);
		
		if ($field_name == 'bulletin_date') {
			$item_object->$field_name = get_bulletin_date($item_object->$field_name);
		}
		if (Item::get_type($field_name) == 'graphic') {
			$item_object->$field_name = replace_blank_image_url($item_object->$field_name,$item_object->bulletin_date);
		}
	}
	$item_object->bulletin_date = get_bulletin_date($item_object->bulletin_date);
}

//  Display header, and errors if any 
$page_title = 'Edit bulletin item';
$header_title = 'MCBC Weekly Bulletin';
$header_subtitle = 'Content Entry';
include('_includes/header.inc.php');

if (!empty($errors)) {

	echo "<p>";
	
	foreach ($errors as $msg) {
		echo "$msg<br>\n";
	}
	echo "</p>\n";
}

?>
<form name="form1" method="post" action="edit_item.php?id=<?php echo $item_id; ?>" enctype=“mulitpart/form-data”>
 	
	<!--  Copy in boilerplate form fields -->
	<?php require('_includes/data_form.inc.php'); ?>
	
</form>

<?php include('_includes/footer.inc.php');?>	