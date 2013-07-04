<?php

// Include item class (and table class)
require_once('classes/item.class.php');

// include database functions, and general functions
require_once('_includes/db_functions.inc.php');
require_once('_includes/functions.inc.php');

$errors = array();

if (isset($_POST['submitted'])) {

	include_once('_includes/item_validate.inc.php');

	//  Create a new object for new event; include necessary code files
	$item_object = new Item($bulletin_date, $position, $title, $subtitle, $content, $excerpt//, $image, $caption, $image_link_url
	);
	
	//  Insert new record
	$result = $item_object->insert_row($dbc);
	
	if ($result) { 
	
		//  New row inserted - Return to list page
			if (!headers_sent($filename, $linenum)) {
				header("Location: list_items.php?date=$bulletin_date");
				exit();
			} else {
				die ( "Headers already sent in $filename on line $linenum<br>\n" .
					  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
					  "<a href=\"list_items.php\">Click here</a> to return to items list.\n");
			}
					
	} else {
		
		// Insert failed; add error message
		$errors[] = "Insert failed.";
	}
}  else {

	// initialize item name variable
	$bulletin_date = $position = $title = $subtitle = $content = $excerpt = '';
}

//  Display header, and errors if any 
$page_title = 'MCBC Weekly Bulletin';
$header_title = 'MCBC Weekly Bulletin';
$header_subtitle = 'Content Entry';
include('_includes/header.inc.php');

?>
<form name="form1" method="post" action="create_item.php" enctype=�mulitpart/form-data�>
    <p>
        <label for="title">Title: </label>
        <input type="text" name="title" id="title" size="40" maxlength="60">
    </p>
    <p>
        <label for="subtitle">Subtitle: </label>
        <input type="text" name="subtitle" id="subtitle" size="40" maxlength="60">
    </p>
    <p>
        <label for="content">Content:<br>
        </label>
        <textarea name="content" id="content" cols="70" rows="10"></textarea>
    </p>
    <p>
        <label for="excerpt">Excerpt: </label>
        <br>
		<input type="text" name="excerpt" id="excerpt" size="80" maxlength="200">
    </p>
	<p>Specify an image URL, or upload a file:
    </p>
	
	<blockquote>
		<p>
			<label for="img_file">Upload</label>
			<br>
			<input type="file" name="img_file" id="img_file" >
		</p>
		
		<p>
			<label for="graphic">File URL: </label>
			<br>
			<input type="input" name="graphic_link" id="graphic_link" size="80" maxlength="200">
		</p>
	</blockquote>
	
	<p>
        <label for="bulletin_date">Date: </label>
        <select name="bulletin_date" id="bulletin_date">
            <option value="20130626">June 26, 2013</option>
            <option value="20130703">July 3, 2013</option>
            <option value="20130710">July 10, 2013</option>
            <option value="20130717">July 17, 2013</option>
        </select>
    </p>
    <p>
        <label for="position">Position: </label>
        <input type="text" name="position" id="position" size="2" maxlength="2">
    </p>
    <p>&nbsp;&nbsp;&nbsp;
        <input type="submit" name="submit" id="submit" value="Submit">
    </p>
    <p>
        <input name="submitted" type="hidden" id="submitted" value="true">
    </p>
</form>

<p><a href="create_bulletin.php?date=<?php echo $bulletin_date; ?>" target="_blank">Generate email bulletin</a>

</body>
</html>