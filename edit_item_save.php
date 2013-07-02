<?php
session_start();

// Item ID must be provided!
if (isset($_GET['id'])) {
	$item_id = $_GET['id'];
} else {

	if (!headers_sent($filename, $linenum)) {
		header("Location: list_items.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bob@marinbike.org\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}
}

// Include item class (and table class)
require_once('classes/item.class.php');

// include database functions, and general functions
require_once('_includes/db_functions.inc.php');
require_once('_includes/functions.inc.php');

$errors = array();

if (isset($_POST['submitted'])) {

	include_once('_includes/item_validate.inc.php');

	if (empty($errors)) { //  Data is valid
	
		//  Create a new object for new event; include necessary code files
		$item_object = new Item($bulletin_date, $position, $title, $subtitle, $content, $excerpt, // $image, $caption, $image_link_url
		$item_id);
		
		//  Update record
		if ($result = $item_object->update_row($dbc)) {
			$_SESSION['message'] = "Update succeeded";
		} else {
			$_SESSION['message'] = "Update failed: " . mysqli_error($dbc);
		}

		//  Return to list page
		header("Location: list_items.php");
		exit();
	}
	
}  else {

	//  Get data for specified primary key
	if (!$return_row = Table::select_by_unique_key($dbc, 'items', 'item_id', $item_id)) {
		die("Could not access item data" . mysqli_error($dbc));
	}
	
	//  Assign event data to variables (use display_date() to reformat date)
	$bulletin_date = $return_row['bulletin_date'];
	$position = $return_row['position'];
	$title = $return_row['title'];
	$subtitle = $return_row['subtitle'];
	$content = $return_row['content'];
	$excerpt = $return_row['excerpt'];
	// $image = $return_row['image'];
	// $caption = $return_row['caption'];
	// $image_link_url = $return_row['image_link_url'];
}

//  Display header, and errors if any 
$page_title = 'MCBC Weekly Bulletin. provisional';
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
<form name="form1" method="post" action="edit_item.php?id=<?php echo $item_id; ?>">
    <p>
        <label for="title">Title: </label>
        <input type="text" name="title" id="title" value="<?php echo $title; ?>" size="40" maxlength="60">
    </p>
    <p>
        <label for="subtitle">Subtitle: </label>
        <input type="text" name="subtitle" id="subtitle" value="<?php echo $subtitle; ?>" size="40" maxlength="60">
    </p>
    <p>
        <label for="content">Content:<br>
        </label>
        <textarea name="content" id="content" cols="70" rows="10"><?php echo $content; ?></textarea>
    </p>
    <p>
        <label for="excerpt">Excerpt: </label>
        <br>
		<input type="text" name="excerpt" id="excerpt" value="<?php echo $excerpt; ?>" size="80" maxlength="200">
    </p>
    <p>Image: </p>
    <p>
        <label for="position">Position: </label>
        <input type="text" name="position" id="position" value="<?php echo $position; ?>" size="2" maxlength="2">
    </p>
    <p>&nbsp;&nbsp;&nbsp;
        <input type="submit" name="submit" id="submit" value="Submit">
    </p>
    <p>
        <input name="submitted" type="hidden" id="submitted" value="true">
        <input name="bulletin_date" type="hidden" id="bulletin_date" value="<?php echo $bulletin_date; ?>">
    </p>
</form>
</body>
</html>
