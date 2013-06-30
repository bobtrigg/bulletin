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

if (isset($_POST['submitted'])) {

	if (isset($_POST['submit'])) {   //  Deletion OK'd: proceed to delete row
	
		//  Include table class definition (to allow use of static delete function)
		require_once('classes/table.class.php');

		if (Table::delete_row($dbc, 'bulletin', 'item_id', $item_id)) {
			$_SESSION['message'] = "Deletion succeeded";
		} else {
			$_SESSION['message'] = "Deletion was NOT successful! ";
		}
	} else {
		$_SESSION['message'] = "Deletion cancelled";
	}
	
	if (!headers_sent($filename, $linenum)) {
		header ("Location:list_items.php");
		exit();
	} else {
		die ( "Headers already sent in $filename on line $linenum<br>\n" .
			  "Please report the above information to your <a href=\"mailto:bobtrigg94930@gmail.com\">system administrator</a>.<br>\n" .
			  "<a href=\"login.php\">Click here</a> to re-login\n");
	}
}

//  Display header and session message if set
$page_title = 'Bulletin Items';
$header_title = 'Bulletin Items';
$header_subtitle = 'Click any item to edit';
include('_includes/header.inc.php');

?>
<form name="delete_item" method="post" action="delete_item.php?id=<?php echo $item_id; ?>">

    <p>&nbsp;&nbsp;&nbsp;
        <input type="submit" name="submit" id="submit" value="Submit">
        &nbsp;&nbsp;&nbsp;
        <input type="submit" name="cancel" id="cancel" value="Cancel">
   </p>
    <p>
        <input name="submitted" type="hidden" id="submitted" value="true">
    </p>
</form>
</body>
</html>
