<?php

require_once(LIB_PATH."database.php");

class DatabaseObject {

	protected static $table_name;

	public static function find_by_id($id=1) {
		global $database;
		$sql = "SELECT * FROM ".static::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1";
		$record_array = self::find_by_sql($sql);
		return (!empty($record_array)? $record_array[0]:false);
	}
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".static::$table_name);
	}
	public static function find_by_sql($sql="") {
		global $database;
		$record_set = $database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($record_set)) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	public static function count_all() {
	
		global $database;
		$sql = "SELECT COUNT(*) FROM ".static::$table_name;
		$record_array = $database->query($sql);
		
		// A query returns an array of rows (in this case just one),
		//   each row in that array is in turn an array of fields.
		// We need the contents of the first field element in the row array
		//   which is the first row element of the returned array.
		
		$row = $database->fetch_array($record_array);
		log_action("Count_all", "Return value is {$row[0]}");
		return $row[0];
	}
	private static function instantiate($record) {

	//  NOTE: This function only works with PHP 5.3 or higher, as it uses the 
	//	Late Static Binding function get_called_class!
	
		$class_name = get_called_class();
		$object = new $class_name;
		
		foreach ($record as $attribute=>$value) {
			if ($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}	
		}
		return $object;
	}
	private function has_attribute($attribute) {
		$object_vars = get_object_vars($this);
		return array_key_exists($attribute, $object_vars);
	}
	protected function sanitized_attributes() {
		global $database;
		$clean_attributes = array();
		// sanitize attribute values before submitting
		// Note: does not alter the actual value of each attribute
		foreach($this->attributes() as $key => $value) {
			$clean_attributes[$key] = $database->escape_value($value);
		}
		return $clean_attributes;
	}
	protected function attributes() {
		// Return an array of attribute keys and their values
		// get_object_vars returns an associative array with all attributes
		// (incl private ones) as the keys and their current values as the value
		$attributes = array();
		foreach(static::$db_fields as $field) {
			if(property_exists($this, $field)) {
				$attributes[$field] = $this->{$field};
			}
		}
		return $attributes;
	}
	public function save() {
		// Creates a new user or update an existing one
		// New data won't have an auto-increment id
		return isset($this->id) ? $this->update() : $this->create();
	}
	public function create() {
	
		global $database;	
		
		$attributes = $this->sanitized_attributes();
		
		$sql = "INSERT INTO " . static::$table_name . " ";
		// note: join() is an alias for implode()
		$sql .= "(" . join(",",array_keys($attributes)) . ") ";
		$sql .= "VALUES ";
		$sql .= "('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		
		if ($database->query($sql)) {
			$this->id = $database->insert_id();
			return true;
		} else {
			return false;
		}
	}
	public function update() {
	
		global $database;
		
		$attributes = $this->sanitized_attributes();
		
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE " . static::$table_name . " SET ";
		$sql .= join(",", array_values($attribute_pairs)) . " ";
		$sql .= "WHERE id = " . $database->escape_value($this->id);
		
		$database->query($sql);
		return ($database->affected_rows() == 1)?true:false;
	}
	public function delete($id) {
	
		global $database;
		
		$sql = "DELETE FROM " . static::$table_name . " ";
		$sql .= "WHERE id = " . $database->escape_value($id) . " ";
		$sql .= "LIMIT 1";
		
		$database->query($sql);
		return ($database->affected_rows() == 1)?true:false;
	}
}
?>