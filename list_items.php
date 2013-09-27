<?php
require_once('_includes/opening_housekeeping.inc.php');

//  Set number of rows per page.
DEFINE('ROWS_PER_PAGE', 15);

$where_clause = '';

if (isset($_POST['submitted'])) {

	//  Validate date entries

	if (isset($_POST['wb_date']) && !is_null($_POST['wb_date']) && $_POST['wb_date'] != '') {
	
		$date = valid_date($_POST['wb_date']);
		
		if (!$date) {
			$errors[] = "Bulletin date is not valid";
			$date = new DateTime();  // Defaults to today
		}
	} else {
		$errors[] = 'You <i>must</i> enter a start date!';
		$date = new DateTime();  // Defaults to today
	}
	
	$where_clause = " WHERE bulletin_date = '" . $date->format('Y-m-d') . "' ";
	
} else {  //  Check for date in $_GET superglobal

	if (isset($_GET['date']) and is_numeric($_GET['date'])) {
		$date = new DateTime($_GET['date']);
	} else {
		$date = new DateTime();
	}
	$where_clause = " WHERE bulletin_date = '" . $date->format('Y-m-d') . "' ";
}
$_SESSION['date'] = $date->format('Ymd');  //  For returning from item entry

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

echo $_SESSION['message'];
?>

<h3>Choose categories and date range you wish to display</h3>

<form name="event_selector" id="event_selector" method="POST" action="list_items.php">

	<p class="event_selector" style="padding:0 0 0 30px;">
		<label for="wb_date">Bulletin date:</label><br>
		<input name="wb_date" type="text" id="wb_date" size="15" maxlength="15" value="<?php echo $date->format('n/j/Y'); ?>">
		<br><span style="font-size:75%">Format: mm/dd/yyyy</span>
	</p>

	<input type="hidden" name="submitted" value="true" />

</form>

<table id="datatable" width="100%" cellspacing="10" cellpadding="0" border="0">
  <tr>
	<th width="30px">Date</th>
    <th width="15px">Position</th>
	<th class="left_aligned">Title</th>
	<th>Approved</th>
	<th>Edit</th>
	<th>Delete</th>
  </tr>
 
<?php

//  Read each row from events table and display data, with edit and delete links
//  Store IDs in an array for previous/next functionality in edit program

$item_ids = array();

while ($item = mysqli_fetch_array($row_resource)) {

	echo "  <tr>\n";
	
	//  Simplify my beautiful code for buggy web host
	$display_date_obj = new DateTime($item['bulletin_date']);
	$display_date = $display_date_obj->format('n/j/Y');
	echo "    <td>" . $display_date . "</td>\n";

	// echo "    <td>" . (new DateTime($item['bulletin_date']))->format('n/j/Y') . "</td>\n";
	echo "    <td>" . $item['position'] . "</td>\n";
	echo "    <td class=\"left_aligned\">" . fix_quoted_quotes($item['title']) . "</td>\n";

	echo "    <td>";
?>
	<input name="approved" type="checkbox" id="approved" <?php if ($item['approved']) {echo "checked";} ?>>
<?php
	echo "</td>\n";
	echo "    <td><a href=\"edit_item.php?id=" . $item['item_id'] . "\">Edit</a></td>\n";
	echo "    <td><a href=\"delete_item.php?id=" . $item['item_id'] . "\">Delete</a></td>\n";
	echo "  </tr>\n\n";
	
	$item_ids[] = $item['item_id'];
}

$_SESSION['item_ids'] = $item_ids;
?>

  </tr>
</table>

<p><a href="create_item.php?date=<?php echo $date->format('Ymd'); ?>">Create a new bulletin item</a><br></p>
<p><a href="bulletin.php?date=<?php echo $date->format('Ymd'); ?>" target="_blank">Generate HTML bulletin</a><br>
	<a href="email_bulletin.php?date=<?php echo $date->format('Ymd'); ?>" target="_blank">Generate email bulletin</a><br>
	<a href="text_bulletin.php?date=<?php echo $date->format('Ymd'); ?>" target="_blank">Generate text bulletin</a>
</p>
</body>
</html>
