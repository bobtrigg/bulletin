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

if (isset($_POST['submitted'])) {

	$item_object = validate_all_items($dbc);
	$item_object->set_pk_id($item_id);

	if (empty($errors)) { //  Data is valid
	
		//  Update record
		if ($result = $item_object->update_row($dbc)) {
			$_SESSION['message'] = "Update succeeded";
		} else {
			$_SESSION['message'] = "Update failed: " . mysqli_error($dbc);
		}

		//  Return to list page
		if (!headers_sent($filename, $linenum)) {
			header("Location: list_items.php?date=" . convert_display_to_numeric($item_object->get_value('bulletin_date')));
			exit();
		} else {
			die ( "Headers already sent in $filename on line $linenum<br>\n" .
				  "Please report the above information to your <a href=\"mailto:bob@marinbike.org\">system administrator</a>.<br>\n" .
				  "<a href=\"login.php\">Click here</a> to re-login\n");
		}
	} else {
		$title = $item_object->get_value('title');
		$subtitle = $item_object->get_value('subtitle');
		$content = $item_object->get_value('content');
		$excerpt = $item_object->get_value('excerpt');
		$position = $item_object->get_value('position');
		$bulletin_date = $item_object->get_value('bulletin_date');
	}
	
}  else {

	//  Get data for specified primary key
	if (!$return_row = Table::select_by_unique_key($dbc, 'items', 'item_id', $item_id)) {
		die("Could not access item data" . mysqli_error($dbc));
	}
	
	//  Assign event data to variables
	$bulletin_date = $return_row['bulletin_date'];
	$position = $return_row['position'];
	$title = $return_row['title'];
	$subtitle = $return_row['subtitle'];
	$content = $return_row['content'];
	$excerpt = $return_row['excerpt'];
	// $image = $return_row['image'];
	// $caption = $return_row['caption'];
	// $image_link_url = $return_row['image_link_url'];
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
<form name="form1" method="post" action="edit_item.php?id=<?php echo $item_id; ?>">

 	
	<!--  Copy in boilerplate form fields -->
	<?php require('_includes/data_form.inc.php'); ?>
	
</form>
</body>
</html>
