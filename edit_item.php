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

function get_bulletin_date($unformatted_date) {

	// Since some vsns of PHP do not allow an object reference symbol after a new object declaration,
	// this code can't be condensed to one line. Hence, since it's reused, it's now a function. WTF!

	$bulletin_date = new DateTime($unformatted_date);	
	return $bulletin_date->format('n/j/Y');
}

function replace_blank_image_url($url,$date) {

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
	
		// $errors = upload_file($_FILES['file_upload']);
		
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

		// Return to list page
		if (!headers_sent($filename, $linenum)) {
		
			// echo 'Submit value = ' . $_POST['submit'];
			// die('die');
		
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
		

	} else {
	
		$title = get_entered_value('title',$item_object);
		$subtitle = get_entered_value('subtitle',$item_object);
		$bookmark = get_entered_value('bookmark',$item_object);
		$content = get_entered_value('content',$item_object);
		$excerpt = get_entered_value('excerpt',$item_object);
		$position = get_entered_value('position',$item_object);
		$unformatted_date = get_entered_value('bulletin_date',$item_object);
		$bulletin_date = get_bulletin_date(get_entered_value('bulletin_date',$item_object));
		$graphic = get_entered_value('graphic',$item_object);
		$large_graphic = get_entered_value('large_graphic',$item_object);
		$alt_text = get_entered_value('alt_text',$item_object);
		$thumbnail = get_entered_value('thumbnail',$item_object);
	}
	
}  else {

	//  Get data for specified primary key
	if (!$return_row = Table::select_by_unique_key($dbc, 'items', 'item_id', $item_id)) {
		die("Could not access item data" . mysqli_error($dbc));
	}
	
	//  Assign event data to variables

	$bulletin_date = get_bulletin_date($return_row['bulletin_date']);
	$position = $return_row['position'];
	$title = fix_quoted_quotes($return_row['title']);
	$subtitle = fix_quoted_quotes($return_row['subtitle']);
	$bookmark = fix_quoted_quotes($return_row['bookmark']);
	$content = fix_quoted_quotes($return_row['content'],true);
	$excerpt = fix_quoted_quotes($return_row['excerpt']);
	$graphic = $return_row['graphic'];
	$large_graphic = $return_row['large_graphic'];
	$alt_text = fix_quoted_quotes($return_row['alt_text']);
	$thumbnail = $return_row['thumbnail'];
	
	$graphic = replace_blank_image_url($graphic,$bulletin_date);
	$large_graphic = replace_blank_image_url($large_graphic,$bulletin_date);
	$thumbnail = replace_blank_image_url($thumbnail,$bulletin_date);
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
	
	<!-- Set up links to edit next and previous items  -->
	<p>
		<?php
			if (!is_null($prev_item_id)) {
				echo "<a href=\"edit_item.php?id=" . $prev_item_id . "\">Previous item</a>&nbsp;&nbsp;&nbsp;";
			}
			if (!is_null($next_item_id)) {
				echo "<a href=\"edit_item.php?id=" . $next_item_id . "\">Next item</a>";
			}
		?>
	</p>
</form>
	
</body>
</html>
