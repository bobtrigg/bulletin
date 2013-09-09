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
		} else {
			$_SESSION['message'] = "\nFile upload failed; update aborted.";
			foreach	($errors as $error) { 
				$_SESSION['message'] .= "\n" . $error;
			}
		}
	} else { 
		$title = $item_object->get_value('title');
		$subtitle = $item_object->get_value('subtitle');
		$content = $item_object->get_value('content');
		$excerpt = $item_object->get_value('excerpt');
		$position = $item_object->get_value('position');
		$bulletin_date = $item_object->get_value('bulletin_date');
		$graphic = $item_object->get_value('graphic');
		$large_graphic = $item_object->get_value('large_graphic');
		$alt_text = $item_object->get_value('alt_text');
		$thumbnail = $item_object->get_value('thumbnail');
		}
	
}  else {  // Form was not yet submitted

	// initialize item name variable

	if (isset($_GET['date']) and is_numeric($_GET['date'])) {
		$date = new DateTime($_GET['date']);
	} else {
		$date = new DateTime();
	}
	$bulletin_date = $date->format('n/j/Y');
	
	$position = $title = $subtitle = $content = $excerpt = $graphic = $large_graphic = $alt_text = $thumbnail = '';
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
