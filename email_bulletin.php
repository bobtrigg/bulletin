<?php
	include('_includes/functions.inc.php');

	//  Check for date in $_GET superglobal; set default if not provided
	if (isset($_GET['date'])) {
		$wb_date = $_GET['date'];
	} else {
		$wb_date = date('Ymd');
	}
	
	//  Get formatted bulletin date and display on page
	$stamp = getstamp($wb_date);
	$display_date = date('F j, Y',$stamp);
	
	include('email_header.inc.php');
	
	require_once('classes/item.class.php');
	require_once('_includes/db_functions.inc.php');

	
	//  Set up query to loop thru items
	$query_string = 'SELECT * FROM items WHERE bulletin_date = "' . $wb_date . '" ORDER BY position';
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