<?php
	//  Set time zone for Bob's house...NOT in L.A.
	date_default_timezone_set('America/Los_Angeles');

	require_once('classes/item.class.php');
	require_once('_includes/db_functions.inc.php');
	include_once('_includes/functions.inc.php');
	

	//  Check for date in $_GET superglobal; set default if not provided
	if (isset($_GET['date'])) {
		$wb_date = new DateTime($_GET['date']);
	} else {
		$wb_date = new DateTime();  // Default to today
	}
	
	//  Get formatted bulletin date and display on page
	$display_date = $wb_date->format('F j, Y');
	include('email_header.inc.php');
	
	//  Set up query to loop thru items
	$query_string = 'SELECT * FROM items WHERE bulletin_date = "' . $wb_date->format('Y-m-d') . '" ORDER BY position';
	$item_list = mysqli_query($dbc, $query_string);
	
	//  Loop through items 
	while ($item = mysqli_fetch_array($item_list)) {
	
		$item_title = $item['title'];
		$item_excerpt = $item['excerpt'];
		$image_url = $item['graphic'];

		include('email_item.inc.php');
	}
	
	echo "</ol>\n</div>\n";

	include('email_footer.inc.php');
?>