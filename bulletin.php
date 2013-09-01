<?php
//  Set time zone for Bob's house...NOT in L.A.
date_default_timezone_set('America/Los_Angeles');

require_once('classes/item.class.php');
require_once('_includes/db_functions.inc.php');
require_once('_includes/functions.inc.php');
include_once('_includes/runtime_parms.inc.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />

<title><?php echo ORG_NAME ?></title>

<link href="<?php echo GLOBAL_CSS ?>" rel="stylesheet" type="text/css">
<link href="<?php echo CUSTOM_CSS; ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo FANCY_BOX ?>jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo FANCY_BOX ?>jquery.fancybox.pack.js"></script>
<script>
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>
<script type="text/javascript" src="<?php echo GLOBAL_JS ?>"></script>

<!-- JS code for Google Analytics  -->  
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25099470-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>
<div id="wrapper">
	<?php include(WEB_HEADER);?>
	<?php include(LEFT_SIDEBAR);?>
	<?php include(RIGHT_SIDEBAR);?>
  <div id="content">
	<?php include(CUSTOM_SHARE);?>

	<div id="wbHeader">
	<p><strong><?php echo ORG_NAME; ?><br>WEEKLY BULLETIN</strong><br>
	
	<?php

		//  Check for date in $_GET superglobal; set default if not provided
		if (isset($_GET['date'])) {
			$wb_date = new DateTime($_GET['date']);
		} else {
			$wb_date = new DateTime();  // Default to today
		}
		
		//  Get formatted bulletin date and display on page
		echo $wb_date->format('F j, Y') . '</p>';
		
		$query_string = 'SELECT * FROM items WHERE bulletin_date = "' . $wb_date->format('Y-m-d') . '" ORDER BY position';
		
		//  1st query: linked TOC
		$item_list = mysqli_query($dbc, $query_string);
		$item_num = 1;
		
		echo "<ol>\n";
		
		//  Loop through items -- **** This logic woill be replaced with JavaScript in a later release!!!
		while ($item = mysqli_fetch_array($item_list)) {
			echo '<li><a href="#' . str_replace(' ','',$item['title']) . '">' . $item['title'] . '</a></li>';
		}
		
		echo "</ol>\n</div>\n";
			
		//  2nd query: content
		$item_list = mysqli_query($dbc, $query_string);
		$item_num = 1;
		
		//  Loop through items for this date
		while ($item = mysqli_fetch_array($item_list)) {
			
			//  This class puts a border at the top
			echo '<div class="topRuledBlock">'; 	
			
			//  Title (with sequence number)
			echo '<p><a name="' . str_replace(' ','',$item['title']) . '"></a><strong>' . $item_num++ . '. ' . $item['title'] . '</strong><br>';
			
			//  Subtitle
			echo $item['subtitle'] . '</p>';
			
			//  Code image, with link to fancybox popup
			if (!is_null($item['graphic'])) {
			
				//  Set image height and width
				$image_size_info = getimagesize($item['graphic']);
				$width = $image_size_info[0];
				$height = $image_size_info[1];
				if ($width > 300 || $height > 300) {
					if ($width > $height) {
						$height *= (300 / $width);
						$width = 300;
					} else {
						$width *= (300 / $height);
						$height = 300;
					}
				}
			
				//  Write HTML to put image, with link, on page
				echo '<a href="' . $item['graphic'] . '" title="'  . $item['title'] . '" class="fancybox">';
				echo '<img src="' . $item['graphic'] . '" alt="' . $item['alt_text'] . '" width="' . $width . '" height="' . $height . '" class="floatRight">';
				echo '</a>';
			}
			
			//  Print content and close div
			echo $item['content'];
			echo '</div>';
		}
	
	?>
  </div>
  <div id="footer">
	<?php include(WEB_FOOTER);?>
  </div>
</div>
</body>
</html>
