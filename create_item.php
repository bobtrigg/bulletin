<?php
require_once('_includes/opening_housekeeping.inc.php');
include_once('_includes/runtime_parms.inc.php');

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
	} else { 
		$title = get_entered_value('title',$item_object);
		$subtitle = get_entered_value('subtitle',$item_object);
		$content = get_entered_value('content',$item_object);
		$excerpt = get_entered_value('excerpt',$item_object);
		$position = get_entered_value('position',$item_object);
		$bulletin_date = get_entered_value('bulletin_date',$item_object);
		$graphic = get_entered_value('graphic',$item_object);
		$large_graphic = get_entered_value('large_graphic',$item_object);
		$alt_text = get_entered_value('alt_text',$item_object);
		$thumbnail = get_entered_value('thumbnail',$item_object);
		}
	
}  else {  // Form was not yet submitted

	// initialize item name variable

	if (isset($_GET['date']) and is_numeric($_GET['date'])) {
		$date = new DateTime($_GET['date']);
	} else {
		$date = new DateTime();
	}
	$bulletin_date = $date->format('n/j/Y');
	
	$position = $title = $subtitle = $content = $excerpt = $alt_text = '';
	$graphic = $large_graphic = $thumbnail = parse_date_string(IMAGE_FOLDER,$date);
}

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

</body>
</html>
