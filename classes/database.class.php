<?php

require_once(LIB_PATH."config.php");

// Using a specifically defined MySQL database makes it easy 
// to define more classes and switch out databases:
class MySQLDatabase {

	private $connection;
	public $last_query;
	private $magic_quotes_on;
	private $real_escape_string_exists;
	
	function __construct() {
		// Create connection to DB when object is instantiated;
		$this->open_connection();
		
		// Check if magic quotes are on, or if escape string function exists
		//    (These properties are used in the escape_values method later)
		
		$this->magic_quotes_on = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists("mysql_real_escape_string");
	}
//	Many of the functions below are generically named, so similar functions can be
//	used in a different SQL flavor. The mysql_ functions are coded within those
//	generically named functions.
	
	public function open_connection() {
		$this->connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
		if (!$this->connection) {
			die("Database connection failed: " . mysql_error());
		} else {
			$db_select = mysql_select_db(DB_NAME, $this->connection);
			if (!$db_select) {
				die("Database selection failed: " . mysql_error);
			}
		}
	}
	public function close_connection() {
		if(isset($this->connection)) {
			mysql_close($this->connection);
			unset($this->connection);
		}
	}
	public function query($sql) {
		$this->last_query = $sql;
		$result = mysql_query($sql, $this->connection);
		$this->confirm_query($result);
		return $result;
	}
 	public function escape_value($value) {
//		Following two lines, part of the base algorithm for prepping code,
//      have been commented here and moved to the beginning of the object's code:

//		$magic_quotes_on = get_magic_quotes_gpc();
//		$new_enough_vsn = function_exists("mysql_real_escape_string");
		
		if ($this->real_escape_string_exists) {
			if ($this->magic_quotes_on) {
				$value = stripslashes($value);
			}
			$value = mysql_real_escape_string($value);
		}
		else {
			if (!$this->magic_quotes_on) {
				$value = addslashes ($value);
			}
		}
		return $value;
	}
	public function fetch_array($result_set) {
		return mysql_fetch_array($result_set);
	}
	public function num_rows($result_set) {
		return mysql_num_rows($result_set);
	}
	public function insert_id() {
		// get the last id inserted over the current db connection
		return mysql_insert_id($this->connection);
	}
	public function affected_rows() {
		return mysql_affected_rows($this->connection);
	}
	private function confirm_query($result) {
		if (!$result) {
			$output = "Database query failed: " . mysql_error() . "<br /><br />";
			$output .= "Last SQL query: " . $this->last_query;
			die($output);
		}
	}
}
$database = new MySQLDatabase();
?>