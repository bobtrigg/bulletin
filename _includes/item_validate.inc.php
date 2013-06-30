<?php
#  item_validate.inc.php
#  This include file contains validation code for bulletin item entry fields
#  It checks to see that all required data was entered and that all entered data is valid.

# Variables used: errors[], $dbc, item object content

	# Validate entry of title
	if (isset($_POST['title']) && (!is_null($_POST['title'])) && ($_POST['title'] != '')) {
		$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
	} else {
		$errors[] = 'You must enter a title';
		$title = "''";
	}

	# Validate entry of subtitle: subtitle is not a required field
	if (isset($_POST['subtitle']) && (!is_null($_POST['subtitle'])) && ($_POST['subtitle'] != '')) {
		$subtitle = mysqli_real_escape_string($dbc, trim($_POST['subtitle']));
	} else {
		$subtitle = "''";
	}

	# Validate entry of content
	if (isset($_POST['content']) && (!is_null($_POST['content'])) && ($_POST['content'] != '')) {
		$content = mysqli_real_escape_string($dbc, trim($_POST['content']));
	} else {
		$errors[] = 'You must enter content';
		$content = "''";
	}

	# Validate entry of excerpt
	if (isset($_POST['excerpt']) && (!is_null($_POST['excerpt'])) && ($_POST['excerpt'] != '')) {
		$excerpt = mysqli_real_escape_string($dbc, trim($_POST['excerpt']));
	} else {
		$errors[] = 'You must enter an excerpt';
		$excerpt = "''";
	}

	# Validate entry of bulletin_date
	if (isset($_POST['bulletin_date']) && (!is_null($_POST['bulletin_date'])) && ($_POST['bulletin_date'] != '')) {
		$bulletin_date = $_POST['bulletin_date'];
	} else {
		$errors[] = 'You must enter a date';
		$bulletin_date = "''";
	}

	# Validate entry of position: position is not a required field
	if (isset($_POST['position']) && (!is_null($_POST['position'])) && ($_POST['position'] != '')) {
		if (is_numeric($_POST['position']) && $_POST['position'] > 0) {
			$position = $_POST['position'];
		} else {
			$position = "''";
		}
	} else {
		$position = "''";
	}

?>
