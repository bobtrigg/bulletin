<?php
require_once('_includes/opening_housekeeping.inc.php');

if (isset($_POST['submitted'])) {

	$item_object = validate_all_items($dbc);
	
	if (empty($errors)) {
	
		// $file_data = $_FILES['file_upload'];
	
		if (empty($errors)) {
	
			//  Insert new record
			$result = $item_object->insert_row($dbc);
			
			if ($result) { 
			
				//  New row inserted - Return to list page
					if (!headers_sent($filename, $linenum)) {
						header("Location: list_items.php?date=" . preg_replace('/\-/','',$item_object->get_value('bulletin_date')));
						exit();
					} else {
						die ( "Headers already sent in $filename on line $linenum<br>\n" .
							  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
							  "<a href=\"list_items.php\">Click here</a> to return to items list.\n");
					}
							
			} else {
				
				// Insert failed; add error message
				$errors[] = "Insert failed.";
			}
		} else {  // This code will not be run unless file upload above is reinstated.
			$_SESSION['message'] = "\nFile upload failed; update aborted.";
			foreach	($errors as $error) { 
				$_SESSION['message'] .= "\n" . $error;
			}
		}
	} else {   // Reset values for redisplay after errors on submit
	
		for ($i=0; $i<$item_object->get_col_array_count(); $i++) {
		
			$field_name = $item_object->get_col_name($i);
			$item_object->$field_name = get_entered_value($field_name,$item_object);
		}
		
		$item_object->bulletin_date = get_bulletin_date($item_object->bulletin_date);
	}
	
}  else {  // Form was not yet submitted

	// initialize item name variable

	$item_object = new Item();

	if (isset($_GET['date']) and is_numeric($_GET['date'])) {
		$date = new DateTime($_GET['date']);
	} else {
		$date = new DateTime();
	}
	$item_object->bulletin_date = $date->format('n/j/Y');
	
	$item_object->position = $item_object->title = $item_object->subtitle = $item_object->bookmark = $item_object->content = $item_object->excerpt = $item_object->alt_text = '';

	$item_object->graphic = $item_object->graphic_link = $item_object->thumbnail = parse_date_string(IMAGE_FOLDER,$date);
}

$next_item_id = null;
$prev_item_id = null;


//  Display header, and errors if any 
$page_title = 'Create bulletin item';
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
<form action="create_item.php" enctype="mulitpart/form-data" method="POST">

	<!--  Copy in boilerplate form fields -->
	<?php include('_includes/data_form.inc.php'); ?>
	
</form>

<p><a href="create_bulletin.php?date=<?php echo $bulletin_date; ?>" target="_blank">Generate email bulletin</a>

<?php include('_includes/footer.inc.php');?>	
