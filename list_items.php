<?php
session_start();

//  Set time zone for Bob's house...NOT in L.A.
date_default_timezone_set('America/Los_Angeles');

//  Set number of rows per page.
DEFINE('ROWS_PER_PAGE', 15);

//  Include database functions and utility functions
require_once('_includes/db_functions.inc.php');
require_once('_includes/functions.inc.php');
require_once('classes/table.class.php');
require_once('classes/date.class.php');

$errors = array();
$where_clause = '';

if (isset($_POST['submitted'])) {

	//  Validate date entries

	if (isset($_POST['wb_date']) && !is_null($_POST['wb_date']) && $_POST['wb_date'] != '') {
	
		$date = Date::valid_date($_POST['wb_date']);
		
		if (!$date) {
			$errors[] = "Bulletin date is not valid";
			$date = new Date();  // Defaults to today
		}
	} else {
		$errors[] = 'You <i>must</i> enter a start date!';
		$date = new Date();  // Defaults to today
	}
	
	$where_clause = " WHERE bulletin_date = '" . $date->get_db_date() . "' ";
	
} else {  //  Check for date in $_GET superglobal

	if (isset($_GET['date']) and is_numeric($_GET['date'])) {
		$date = new Date($_GET['date']);
	} else {
		$date = new Date();
	}
	$where_clause = " WHERE bulletin_date = '" . $date->get_db_date() . "' ";
}
$_SESSION['date'] = $date->get_numeric_date();  //  For returning from item entry

//  Display header and session message if set
$page_title = 'Bulletin Items';
$header_title = 'Bulletin Items';
$header_subtitle = 'Click any item to edit';
include('_includes/header.inc.php');

//  Check for page number in $_GET superglobal
if (isset($_GET['page_num'])) {
	$page_num = $_GET['page_num'];
} else {
	$page_num = 1;
}

if (!empty($errors)) {

	echo "<p>";
	
	foreach ($errors as $msg) {
		echo "$msg<br>\n";
	}
	echo "</p>\n";
}

#####  Determine parameters for call to select function

//  Retrieve total number of rows in bulletin table
$total_num_rows = Table::get_num_rows($dbc, 'items');
//  Include logic to assign pagination variables
require_once('_includes/set_page_vars.inc.php');

//  Call get_list to parse select query
$row_resource = Table::get_list($dbc, 'items', $start_rec, $num_page_rows, 'bulletin_date DESC, position ASC', '', $where_clause);

?>

<h3>Choose categories and date range you wish to display</h3>

<form name="event_selector" id="event_selector" method="POST" action="list_items.php">

	<p class="event_selector" style="padding:0 0 0 30px;">
		<label for="wb_date">Bulletin date:</label><br>
		<input name="wb_date" type="text" id="wb_date" size="15" maxlength="15" value="<?php echo $date->get_display_date(); ?>">
		<br><span style="font-size:75%">Format: mm/dd/yyyy</span>
	</p>

	<input type="hidden" name="submitted" value="true" />

</form>

<table id="datatable" width="100%" cellspacing="10" cellpadding="0" border="0">
  <tr>
	<th width="30px">Date</th>
    <th width="15px">Position</th>
	<th>Title</th>
	<th>Edit</th>
	<th>Delete</th>
  </tr>
 
<?php

//  Read each row from events table and display data, with edit and delete links
while ($item = mysqli_fetch_array($row_resource)) {

	echo "  <tr>\n";
	echo "    <td>" . (new Date($item['bulletin_date']))->get_display_date() . "</td>\n";
	echo "    <td>" . $item['position'] . "</td>\n";
	echo "    <td>" . $item['title'] . "</td>\n";
	echo "    <td><a href=\"edit_item.php?id=" . $item['item_id'] . "\">Edit</a></td>\n";
	echo "    <td><a href=\"delete_item.php?id=" . $item['item_id'] . "\">Delete</a></td>\n";
	echo "  </tr>\n\n";
}
?>

  </tr>
</table>

<p><a href="email_bulletin.php?date=<?php echo $date->get_numeric_date(); ?>" target="_blank">Generate email bulletin</a>
<p><a href="create_item.php">Create a new bulletin item</a>
