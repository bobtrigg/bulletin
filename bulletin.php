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

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>

<?php include('_includes/fancybox.inc.php'); ?>

<?php
	if (defined('GLOBAL_JS') && (GLOBAL_JS != '')) {
		echo "<script type=\"text/javascript\" href=\"" . GLOBAL_JS . "\"></script>\n";
	}
	if (defined('GLOBAL_CSS') && (GLOBAL_CSS != '')) {
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . GLOBAL_CSS . "\" />\n";
	}
?>
<link rel="stylesheet" type="text/css" href="_css/bulletin.css" />

<!-- Include script to render email adresses -->
<script type="text/javascript" src="_js/mailguard.js"></script>

<!-- Run script to generate table of contents -->
<script type="text/javascript" src="_js/toc.js"></script>
<script type="text/javascript">
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
			
			<ol id="toc" style="list-style:none;">
				<!-- Table of contents will be inserted here by toc.js -->
			</ol>
			
		</div>
		
	<?php

		//  Query for content
		$query_string = 'SELECT * FROM items WHERE bulletin_date = "' . $wb_date->format('Y-m-d') . '" ORDER BY position';
		
		$item_list = mysqli_query($dbc, $query_string);
		$item_num = 1;
		
		//  Loop through items for this date
		while ($item = mysqli_fetch_array($item_list)) {
			
			//  This class puts a border at the top
			//  This class puts a border at the top
			echo '<div class="topRuledBlock">' . "\n"; 	
			
			//  Title (with sequence number)
			if ($item['bookmark'] == '' || $item['bookmark'] == ' ') {
				$bookmark =  generate_bookmark($item['title']);
			} else {
				$bookmark = $item['bookmark'];
			}
			echo '<h4><a name="' . $bookmark . '"></a><strong>' . fix_quoted_quotes($item['title']) . '</strong></h4>' . "\n";
			
			//  Subtitle
			if ($item['subtitle'] == '' || $item['subtitle'] == ' ') {
				echo '<br>';
			} else {
				echo '<p>' . fix_quoted_quotes($item['subtitle']) . '</p>' . "\n";
			}
			
			//  Code image, with link to fancybox popup
			if (!is_null($item['graphic']) && $item['graphic'] != '' && $item['graphic'] != ' ') {
			
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
				
				//  Make image target open with fancybox only if it's an image file
				if (in_array(substr($item['large_graphic'],-3),array("png","jpg","gif"))) {
					$class_name = 'class="fancybox"';
				}

				//  Write HTML to put image, with link, on page
				echo '<a href="' . $item['large_graphic'] . '" title="'  . fix_quoted_quotes($item['title']) . '" ' . $class_name . ' target="_blank">' . "\n";				
				
				echo '<img src="' . $item['graphic'] . '" alt="' . fix_quoted_quotes($item['alt_text']) . '" width="' . $width . '" height="' . $height . '" class="floatRight">';
				echo '</a>';
			}
			
			//  Print content and close div
			echo fix_quoted_quotes($item['content'],true) . "\n";
			echo '</div>' . "\n";
		}
	
	?>
    <?php
		if (defined('BULLETIN_FOOTER') && (BULLETIN_FOOTER != '')) {
			include (BULLETIN_FOOTER);
		}
	?>
  </div>
  <div id="footer">
	<?php 
		if (defined('WEB_FOOTER') && (WEB_FOOTER != '')) {
			include (WEB_FOOTER);
		}
	?>
  </div>
</div>
</body>
</html>
