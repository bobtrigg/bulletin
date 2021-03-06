<?php
#  table.class.php - defines table class, used to generate database functions based on class properties

//  Let's assume if we're working with tables we need a database connection:
include_once('_includes/db_connect.inc.php');

class Table {

	private $table_name;               //  Name of database table
	protected $pk_id;                  //  Primary key
	private $id_col_name;              //  Name of primary key id column
	private $col_array;                //  Array of names of all other columns
	private $num_cols;                 //  Number of non-key columns

	protected $data_array;             //  Array of data values in the table, indexed by $col_array values
	
	public function __construct($table_name, $id_col_name, $col_array) {
	
	#  Constructor function creates a new table object
	#  Received parameters: table name (string) and column name (array)
	
		//  Assign parameter value to table name and primary key column name properties
		$this->table_name = (string) $table_name;
		$this->id_col_name = (string) $id_col_name;
		
		//  Initialize array of column names and populate with foreach, using parameter array
		
		$this->col_array = array();
		
		foreach ($col_array as $col_name) {
			$this->col_array[] = (string) $col_name;
		}
		//  Assign the number of columns property
		$this->num_cols = count($col_array);
	}  //  END __construct
	
	public function get_value($name) {
	//  Generic getter function
		return $this->data_array[$name];
	}
	
	public function set_value($name,$value) {
	//  Generic setter function
		$this->data_array[$name] = $value;
	}
	public function set_pk_id($value) {
		$this->pk_id = $value;
	}
	
	public function select_by_pk ($dbc) {
		
	#  Selects one table row, based on primary key
	#  Returns Boolean false if row does not exist
	#  Returns value of row if row does exist, which will interpret as true

		$query_string = "SELECT * " .
						" FROM $this->table_name " .
						" WHERE $this->id_col_name = '" . $this->pk_id . "' " .
						" LIMIT 1 ";
						
		return return_resource($dbc, $query_string);

	}  //  END select_by_pk
	
	public static function select_by_unique_key($dbc, $table_name, $col_name, $value) {
	
	#  Selects one table row, based on a non-primary key column
	#  Logic enforces one row only from select stmt
	
		$query_string = "SELECT * " .
						" FROM $table_name " .
						" WHERE $col_name = '$value' " .
						" LIMIT 1 ";
						
		return return_resource($dbc, $query_string);
	}
	public function insert_row($dbc) {
		
		#  Insert a row into the database table
		#  Query string is built from the table property array of column names and the child class object's array of values
		#  If insert fails, exit program with die() and display error info
		#  If insert succeeds, function returns new id assigned by auto-increment for this category

		$query_string = "INSERT INTO $this->table_name ";
		
		#####  Dynamically assign the column name list in the query string, using the property array
		
		//  Construct column name list by imploding array
		$query_string .= " ( " . implode (",", $this->col_array) . " ) ";
		
		//  Add the value clause, using the parameter string of values
		$query_string .= " VALUES ('" . implode ("','", $this->data_array) . "')";
		
		if (!@mysqli_query($dbc, $query_string)) {
			die("Could not insert row: " . $query_string . "<br>" . mysqli_error($dbc));
		}
		
		return mysqli_insert_id($dbc);
	}
	public function update_row($dbc) {
		
		#  Update a row in the database
		#  This method uses the object property arrays of column names (in the table
		#    class) and values (in the child object) to generate the UPDATE statement
		#  Returns Boolean to indicate whether update succeeded.
		
		//  But first: if arrays aren't equal length we're in trouble...
		//  This shouldn't happen, since arrays are controlled w/in the object; but...
		if (count($this->col_array) != count($this->data_array)) {
			die("Update failed: number of column names (" . count($this->col_array) . ") not equal to number of values supplied (" . count($this->data_array) . ").");
		}
		
		$query_string = "UPDATE $this->table_name SET ";
		
		#####  Construct SET clause using property arrays
		
		//  Loop through arrays, assiging values to each column name 
		for ($ndx = 0; $ndx < count($this->col_array); $ndx++) {
		
			//  Add comma separator to all but first and last rows
			if ($ndx > 0) { 
				$query_string .= ", ";
			}
			
			//  Add new name/value assignment to SET clause
			//  Column name array is indexed by number
			//  Data array is indexed by column name, which is the value in the column name array
			$query_string .= $this->col_array[$ndx] . " = '" . $this->data_array[$this->col_array[$ndx]] . "'";
		}
		
		//  Finish by using primary key for this object in WHERE clause
		$query_string .= " WHERE $this->id_col_name = $this->pk_id";
						
		// $_SESSION['message'] = "<br>$query_string";  //  For debugging
						
		if (mysqli_query($dbc, $query_string)) {
			return true;
		} else {
			die("Could not update row: " . $query_string . "<br>" );
		}
	}
	public static function delete_row($dbc, $table_name, $id_col_name, $key_val) {
		
		#  Delete a row from the database based on primary key id 
		#  Returns Boolean to indicate whether delete succeeded.

		$query_string = "DELETE FROM $table_name " .
						"WHERE $id_col_name = $key_val";
						
		//  Use for debugging: $_SESSION['query'] = $query_string;
						
		return mysqli_query($dbc, $query_string);
	}
	public function get_col_array_count() {
		return count($this->col_array);
	}
	public function get_col_name($ndx) {
		return $this->col_array[$ndx];
	}
	public function echo_col_names($ndx=NULL) {
	
	#  Displays the elements of the array of column names
	#  Used for debugging; not currently called from any live code
	
		if (!is_null($ndx)) {
			echo "--" . $this->col_array[$ndx] . "<br>";
		} else {
			foreach($this->col_array as $col_name) {
				echo "--" . $col_name . "<br>";
			}	
		}
	}
	public static function get_list($dbc, $table_name, $start_rec = 1, $num_rows = ROWS_PER_PAGE, $sort_field = NULL, $join_clause = NULL, $where_clause=NULL) {
		
	#  Creates a query to select a set of rows from specified table for display
	#  Uses parameters $start_rec and $num_rows to paginate data, if provided
	#  Uses sort field parameter to sort rows, if provided.
	#  Returns resource from query, which will be used in a foreach in calling script

		$query_string = "SELECT * FROM $table_name ";
		
		//  Add optional JOIN clause
		if (!is_null($join_clause)) {
			$query_string .= " " . $join_clause . " ";
		}

		//  Add optional WHERE clause
		if (!is_null($where_clause)) {
			$query_string .= " " . $where_clause . " ";
		}

		//  Add ORDER BY clause if sort_field is provided
		if (!is_null($sort_field)) {
			$query_string .= " ORDER BY $sort_field ";
		}

		$query_string .= " LIMIT $start_rec, $num_rows ";
		
		// $_SESSION['message'] = $where_clause . '<br>' . $query_string;
		
		return mysqli_query($dbc, $query_string);
	}
	
	public static function get_num_rows($dbc, $table_name, $where_clause=NULL) {

	#  Creates a query to select the number of rows in the specified table
	#  Assigns query string using table name parameter
	#  Calls return_resource() to execute query, which returns array containing row count.
	#  Returns first element of array from query, which is the row count

		$query_string = "SELECT count(*) " .
						" FROM $table_name ";
						
		if (!is_null($where_clause)) {
			$query_string .= $where_clause;
		}

		$return_array = return_resource($dbc, $query_string);
		
		return $return_array[0];

	}  //  END get_num_rows
}
?>