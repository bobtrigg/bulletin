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

//  Get item data; include necessary code files
require_once('classes/table.class.php');
require_once('_includes/db_functions.inc.php');
require_once('_includes/functions.inc.php');

$item_data = Table::select_by_unique_key($dbc, 'items', 'item_id', $item_id);

if (isset($_POST['submitted'])) {

	if (isset($_POST['submit'])) {   //  Deletion OK'd: proceed to delete row
	
		if (Table::delete_row($dbc, 'items', 'item_id', $item_id)) {
			$_SESSION['message'] = "Deletion succeeded";
		} else {
			$_SESSION['message'] = "Deletion was NOT successful: " . mysqli_error($dbc);
		}
	} else {
		$_SESSION['message'] = "Deletion cancelled";
	}
	
	if (!headers_sent($filename, $linenum)) {
		$wb_date = new DateTime($item_data['bulletin_date']);
		header ("Location:list_items.php?date=" . $wb_date->format('Ymd'));
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

	<p>Really delete <?php echo $item_data['title']; ?>?</p>

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
