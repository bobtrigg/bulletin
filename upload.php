<?php
$max_file_size = 1048576;

//  Check for date in $_GET superglobal; set default if not provided
if (isset($_GET['year'])) {
	$year = $_GET['year'];
} else {
	$year = date('Y');  // Default to current year
}


if(isset($_POST['submitted'])) {
	
	$photo = $_FILES['file_upload'];
	
	$tmp_name = $photo['tmp_name'];
	$name = basename($photo['name']);
	$type = $photo['type'];
	$size = $photo['size'];
	
	$target_path = "Images/" . $year . "/" . $name;
	
	if (move_uploaded_file($tmp_name,$target_path)) {
		$message =  "<h3>Moving " . $tmp_name . " to " . $target_path . "</h3>";
	} else {
		$message =  "<h3>Move was unsuccessful</h3>";
	}
	
}

//  Display header and session message if set
$page_title = 'Bulletin Items';
$header_title = 'Bulletin Items';
$header_subtitle = 'Click any item to edit';
include('_includes/header.inc.php');

if (!empty($errors)) {

	echo "<p>";
	
	foreach ($errors as $msg) {
		echo "$msg<br>\n";
	}
	echo "</p>\n";
}

?>
	<h2>Photo Upload</h2>
	
	<?php echo $message; ?>
	
	<form action="upload.php" enctype="multipart/form-data" method="POST">
	
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size;?>" />
		<input type="file" name="file_upload" />
		<p>&nbsp;</p>
		<input type="submit" name="submit" value="Upload" />
		<input name="submitted" type="hidden" id="submitted" value="true" />
	</form>
</body>
</html>

