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

<title><?php echo ORG_NAME ?> Weekly Bulletin</title>

<?php
	if (defined('GLOBAL_CSS') && (GLOBAL_CSS != '')) {
		echo "<link href=\"" . GLOBAL_CSS . "\" rel=\"stylesheet\" type=\"text/css\">\n";
	}
	if (defined('CUSTOM_CSS') && (CUSTOM_CSS != '')) {
		echo "<link href=\"" . CUSTOM_CSS . "\" rel=\"stylesheet\" type=\"text/css\">\n";
	}
?>
	
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<?php
	if (defined('FANCY_BOX') && (FANCY_BOX != '')) {
		echo "<link rel=\"stylesheet\" href=\"" . FANCY_BOX .  "jquery.fancybox.css\" type=\"text/css\" media=\"screen\" />\n";
		echo "<script type=\"text/javascript\" src=\"" . FANCY_BOX . "jquery.fancybox.pack.js\"></script>\n";
	}
?>
<script>
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>
<?php
	if (defined('GLOBAL_JS') && (GLOBAL_JS != '')) {
		echo "<script type=\"text/javascript\" src=\"" . GLOBAL_JS . "\"></script>\n";
	}
?>
<script type="text/javascript" src="_js/toc.js"></script>
<!-- Run script to generate table of contents -->
<script>
$("document").ready(function() {
	gen_toc(true);
});
</script>


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

	<?php 
		include(WEB_HEADER);
		include(LEFT_SIDEBAR);
		include(RIGHT_SIDEBAR);
	?>
	
	<div id="content">
	
	<?php include(CUSTOM_SHARE);?>

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
			echo '<p class="LargeType">' .$wb_date->format('F j, Y') . '</p>';
			
		?>
			
			<ol id="toc">
				<!-- Table of contents will be inserted here by toc.js -->
			</ol>
			
		</div>
		
	<?php
		// Following code is superceded by the toc JavaScript
		
			// //  1st query: linked TOC
			// $item_list = mysqli_query($dbc, $query_string);
			// $item_num = 1;
			
			// echo "<ol>\n";
			
			// //  Loop through items -- **** This logic woill be replaced with JavaScript in a later release!!!
			// while ($item = mysqli_fetch_array($item_list)) {
				// echo '<li><a href="#' . str_replace(' ','',$item['title']) . '">' . $item['title'] . '</a></li>';
			// }
			
			// echo "</ol>\n</div>\n";

		//  Query for content
		$query_string = 'SELECT * FROM items WHERE bulletin_date = "' . $wb_date->format('Y-m-d') . '" ORDER BY position';
		
		$item_list = mysqli_query($dbc, $query_string);
		$item_num = 1;
		
		//  Loop through items for this date
		while ($item = mysqli_fetch_array($item_list)) {
			
			//  This class puts a border at the top
			echo '<div class="topRuledBlock">'; 	
			
			//  Title (with sequence number)
			echo '<h4><a name="' . str_replace(' ','',$item['title']) . '"></a><strong>' . $item['title'] . '</strong></h4>';
			
			//  Subtitle
			echo '<p>' . $item['subtitle'] . '</p>';
			
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
				echo '<a href="' . $item['large_graphic'] . '" title="'  . $item['title'] . '" class="fancybox">';
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
