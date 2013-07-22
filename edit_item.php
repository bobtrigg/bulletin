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
				$_SESSION['message'] .= "\nInside script";


if (isset($_POST['submitted'])) {

				$_SESSION['message'] .= "\nInside submitted logic";

				$item_object = validate_all_items($dbc);
	$item_object->set_pk_id($item_id);

	if (empty($errors)) { //  Data is valid
	
		// $errors = upload_file($_FILES['file_upload']);
		
		if (empty($errors)) {
	
			//  Update record
			if ($result = $item_object->update_row($dbc)) {
				$_SESSION['message'] .= "\nUpdate succeeded";
			} else {
				$_SESSION['message'] .= "\nUpdate failed: " . mysqli_error($dbc);
			}
		} else {
			$_SESSION['message'] .= "\nFile upload failed; update aborted.";		
		}

		// Return to list page
		if (!headers_sent($filename, $linenum)) {
			header("Location: list_items.php?date=" . preg_replace('/\-/','',$item_object->get_value('bulletin_date')));
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
		$bulletin_date = (new DateTime($item_object->get_value('bulletin_date')))->format('n/j/Y');
		$graphic = $item_object->get_value('graphic');
		$alt_text = $item_object->get_value('alt_text');
		$thumbnail = $item_object->get_value('thumbnail');
	}
	
}  else {

	//  Get data for specified primary key
	if (!$return_row = Table::select_by_unique_key($dbc, 'items', 'item_id', $item_id)) {
		die("Could not access item data" . mysqli_error($dbc));
	}
	
	//  Assign event data to variables
	$bulletin_date = (new DateTime($return_row['bulletin_date']))->format('n/j/Y');
	$position = $return_row['position'];
	$title = $return_row['title'];
	$subtitle = $return_row['subtitle'];
	$content = $return_row['content'];
	$excerpt = $return_row['excerpt'];
	// $image = $return_row['image'];
	// $caption = $return_row['caption'];
	$graphic = $return_row['graphic'];
	$alt_text = $return_row['alt_text'];
	$thumbnail = $return_row['thumbnail'];
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
</body>
</html>
