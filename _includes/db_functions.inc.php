<?php
// db_functions.inc.php
// include file for database functions

require_once('_includes/db_connect.inc.php');

function return_resource($dbc, $query_string) {

#  Performs a select statement based on $query_string parameter
#  Fetch first record and return if retrieved.
#  Return false if failure.

	$user_resource = mysqli_query($dbc, $query_string);
	
	if ($user_resource) {
		return mysqli_fetch_array($user_resource);
	} else {
		return false;
	}
}  //  END function return_resource

function name_exists($dbc, $table_name, $fld_name, $value) {
	
#  Selects one table row, based on table name, field name, and value
#  Returns Boolean false if row does not exist
#  Returns value of row if row does exist, which will interpret as true
#  Used to validate entry of unique fields (cat_name, event_name, username)

	$query_string = "SELECT * " .
					" FROM $table_name " .
					" WHERE $fld_name = '" . $value . "' " .
					" LIMIT 1 ";
					
	return return_resource($dbc, $query_string);

}  //  END function name_exists
?>