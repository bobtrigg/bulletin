<?php
//  Set time zone for Bob's house...NOT in L.A.
date_default_timezone_set('America/Los_Angeles');

// require_once('classes/item.class.php');
require_once('_includes/db_functions.inc.php');
require_once('_includes/functions.inc.php');
include_once('_includes/runtime_parms.inc.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />

	<title><?php echo ORG_NAME ?> Weekly Bulletin</title>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
	
	<!-- Remove graphic content and display link targets -->
	<script type="text/javascript" src="_js/text_vsn_script.js"></script>

	<!-- Run script to generate table of contents -->
	<script type="text/javascript" src="_js/toc.js"></script>
	
	<!-- Include script to render email addresses -->
	<script type="text/javascript" src="_js/mailguard.js"></script>
	
	<!-- Change unordered list indicators from dot to circle -->
	<script>
		$("document").ready(function() {
			$("ul").attr("type","circle");
		});
	</script>
	
	</head>

<body>
	<div id="wbHeader">
	
		<h3><?php echo ORG_NAME; ?><br>WEEKLY BULLETIN</h3>
		
		<?php

			//  Check for date in $_GET superglobal; set default if not provided
			if (isset($_GET['date'])) {
				$wb_date = new DateTime($_GET['date']);
			} else {
				$wb_date = new DateTime();  // Default to today
			}
			
			//  Get formatted bulletin date and display on page
			echo '<p><strong>' .$wb_date->format('F j, Y') . '</strong></p>';
			
		?>
			
		<ol id="toc">
			<!-- Table of contents will be inserted here by toc.js -->
		</ol>
		
	</div>
	
	<p>_________________________________________________________________</p>
	<p>&nbsp;</p>
		
	<?php

		//  Query for content
		$query_string = 'SELECT * FROM items WHERE bulletin_date = "' . $wb_date->format('Y-m-d') . '" ORDER BY position';
		
		$item_list = mysqli_query($dbc, $query_string);
		$item_num = 1;
		
		//  Loop through items for this date
		while ($item = mysqli_fetch_array($item_list)) {
			
			//  Title (with sequence number)
			echo "<h4 style=\"margin-bottom:0;\">" . fix_quoted_quotes($item['title']) . "</h4>\n";
			
			//  Subtitle
			if ($item['subtitle'] == '' || $item['subtitle'] == ' ') {
				echo '<br>';
			} else {
				echo fix_quoted_quotes($item['subtitle']) . "\n";
			}
			
			//  Code image, with link to fancybox popup
			//  Print content and close div
			echo fix_quoted_quotes($item['content'],true) . "\n";
 	
			echo "<p>_________________________________________________________________</p>";
		
		}
	
	?>
 <div id="footer">
	<?php include(EMAIL_FOOTER);?>
  </div>
</body>
</html>
