<?php

// Include item class (and table class)
require_once('classes/item.class.php');

// include database, validation, and general functions
require_once('_includes/db_functions.inc.php');
require_once('_includes/item_validate.inc.php');
require_once('_includes/functions.inc.php');

$errors = array();

if (isset($_POST['submitted'])) {

	$item_object = validate_all_items($dbc);
	
	if (empty($errors)) {

		//  Insert new record
		$result = $item_object->insert_row($dbc);
		
		if ($result) { 
		
			//  New row inserted - Return to list page
				if (!headers_sent($filename, $linenum)) {
					header("Location: list_items.php?date=$bulletin_date");
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
		$title = $item_object->get_value('title');
		$subtitle = $item_object->get_value('subtitle');
		$content = $item_object->get_value('content');
		$excerpt = $item_object->get_value('excerpt');
		$position = $item_object->get_value('position');
		$bulletin_date = $item_object->get_value('bulletin_date');
	}
	
}  else {

	// initialize item name variable
	$bulletin_date = $position = $title = $subtitle = $content = $excerpt = '';
}

//  Display header, and errors if any 
$page_title = 'MCBC Weekly Bulletin';
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
<form name="form1" method="post" action="create_item.php" enctype=“mulitpart/form-data”>
 	<p>
        <label for="bulletin_date">Bulletin Date: </label>
        <select name="bulletin_date" id="bulletin_date">
            <option value="20130626">June 26, 2013</option>
            <option value="20130703">July 3, 2013</option>
            <option value="20130710">July 10, 2013</option>
            <option value="20130717">July 17, 2013</option>
        </select>
    </p>
	
	<!--  Copy in boilerplate form fields -->
	<?php require('_includes/data_form.inc.php'); ?>
	
</form>

<p><a href="create_bulletin.php?date=<?php echo $bulletin_date; ?>" target="_blank">Generate email bulletin</a>

</body>
</html>
