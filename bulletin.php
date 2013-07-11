<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Marin County Bicycle Coalition</title>

<link href="../../css/global.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<link rel="stylesheet" href="../../fancybox/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="../../fancybox/jquery.fancybox.pack.js"></script>
<script>
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>
<script type="text/javascript" src="/_js/global.js"></script>

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
	<?php include('../../_includes/Header.htm');?>
	<?php include('../../_includes/LeftCol.htm');?>
	<?php include('../../_includes/RightCol.htm');?>
  <div id="content">
	<?php include('../../_includes/share.htm');?>

	<div id="wbHeader">
	<p><strong>MARIN COUNTY BICYCLE COALITION (MCBC)<br>WEEKLY BULLETIN</strong><br>
	
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
		echo date('F j, Y',$stamp) . '</p>'	;
		
		require_once('classes/item.class.php');
		require_once('_includes/db_functions.inc.php');
	
		//  Reformat date for database use and create query string
		$db_date = db_format_date($wb_date);
		$query_string = 'SELECT * FROM items WHERE bulletin_date = "' . $db_date . '" ORDER BY position';
		
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
			if (!is_null($item['graphic_link'])) {
			
				//  Set image height and width
				$image_size_info = getimagesize($item['image_link_url']);
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
				echo '<a href="' . $item['image_link_url'] . '" title="'  . $item['title'] . '" class="fancybox">';
				echo '<img src="' . $item['image_link_url'] . '" alt="' . $item['title'] . '" width="' . $width . '" height="' . $height . '" class="floatRight">';
				echo '</a>';
			}
			
			//  Print content and close div
			echo $item['content'];
			echo '</div>';
		}
	
	?>
  </div>
  <div id="footer">
	<?php include('../../_includes/footer.htm');?>
  </div>
</div>
</body>
</html>
