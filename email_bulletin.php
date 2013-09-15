<?php
	//  Set time zone for Bob's house...NOT in L.A.
	date_default_timezone_set('America/Los_Angeles');

	require_once('classes/item.class.php');
	require_once('_includes/db_functions.inc.php');
	include_once('_includes/functions.inc.php');
	include_once('_includes/runtime_parms.inc.php');

	//  Check for date in $_GET superglobal; set default if not provided
	if (isset($_GET['date'])) {
		$wb_date = new DateTime($_GET['date']);
	} else {
		$wb_date = new DateTime();  // Default to today
	}
	
	//  Get formatted bulletin date and display on page
	$display_date = $wb_date->format('F j, Y');
	include(EMAIL_HEADER);
	
	//  Set up query to loop thru items
	$query_string = 'SELECT * FROM items WHERE bulletin_date = "' . $wb_date->format('Y-m-d') . '" ORDER BY position';
	$item_list = mysqli_query($dbc, $query_string);
	
	$webfile_url = parse_date_string(FILE_NAME,$wb_date);

	//  Loop through items 
	while ($item = mysqli_fetch_array($item_list)) {
	
		$item_title = fix_quoted_quotes($item['title']);
		$item_excerpt = fix_quoted_quotes($item['excerpt']);
		$thumbnail = $item['thumbnail'];
		
		if ($item['bookmark'] == '' || $item['bookmark'] == ' ') {
			$bookmark =  generate_bookmark($item_title);
		} else {
			$bookmark = $item['bookmark'];
		}
		
		// If thumbnail size graphic was specified, use it; otherwise use main graphic
		if (isset($thumbnail) && !is_null($thumbnail)) {
			$image_url = $thumbnail;
		} else {
			$image_url = $item['graphic'];
		}
		$alt_text = $item['alt_text'];
		
		include('_includes/email_item.inc.php');
	}
	
	echo "</ol>\n</div>\n";

	include(EMAIL_FOOTER);
?>