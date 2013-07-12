<?php
#  date.class.php 
#  Created July, 2013, by Bob Trigg

class Date  {

	protected $datestamp;

######  Constructor function creates a new bulletin item
######  function assigns primary key value and an array of other column values, then calls parent (table) constructor
	
	// public function __construct($datestamp) {
		// $this->datestamp = $datestamp;
	// }
	
	public function __construct($datestr='') {
			
		if (strpos($datestr,'/')) {
			// echo "computing date from display format " . $datestr . "<br>";
			$this->datestamp = $this->convert_display_to_stamp($datestr);
		} elseif (strpos($datestr,'-')) {
			// echo "computing date from database format<br>";
			$this->datestamp = $this->convert_db_to_stamp($datestr);
		} elseif (is_numeric($datestr)) {
			$this->datestamp = $this->convert_numeric_to_stamp($datestr);
		} else {
			// echo "computing date from no format<br>";
			$this->datestamp = $this->get_today();
		}
	}
	
	public function __toString() {
		return date('Y-m-d',$this->datestamp);
	}
	// public function _construct() {
		// $this->datestamp = $this->get_today();	
	// }
	
	public function get_date_stamp() {
		return $this->datestamp;
	}
	
	public function get_display_date() {
		return date('n/j/Y',$this->datestamp);
	}
	
	public function get_db_date() {
		return date('Y-m-d',$this->datestamp);
	}
	
	public function get_numeric_date() {
		return date('Ymd',$this->datestamp);
	}
	
	public function convert_display_to_stamp($datestr) {
	
	#  Converts a date in mm/dd/yyyy format to a datestamp
	#  Returns datestamp

		#####  Get date components
		$components = explode('/',$datestr);
		if (count($components) < 3) {
			return $this->get_today();
		}
		
		$month = $components[0];
		$day = $components[1];
		$year = $components[2];
		
		#####  Return stamp using components
		
		return mktime(0,0,0,$month, $day, $year);
	}
	
	public function convert_db_to_stamp($datestr) {
	
	#  Converts a date in yyyy-mm-dd format to a datestamp
	#  Returns datestamp

		#####  Get date components
		$components = explode('-',$datestr);
		if (count($components) < 3) {
			return $this->get_today();
		}
		$year = $components[0];
		$month = $components[1];
		$day = $components[2];
		
		#####  Return stamp using components
		
		return mktime(0,0,0,$month, $day, $year);
	}
	
	public function convert_numeric_to_stamp($datestr) {
	
	#  Converts numeric date in yyyymmdd or yymmdd format to a stamp
	#  If string is not 6 or 8 digits, returns today's date stamp
	
		$str_len = strlen($datestr);
		
		if ($str_len != 6 && $str_len != 8) {
			return $this->get_today();
		}
		
		$year = substr($datestr, 0, $str_len - 4);
		$month = substr($datestr, $str_len - 4, 2);
		$day = substr($datestr, $str_len - 2, 2);
		
		return mktime(0,0,0,$month, $day, $year);
	}
	
	public function get_today() {
	
	#  Returns date stamp of today's date
	
		$today = getdate();
		
		return mktime(0,0,0,$today['mon'],$today['mday'],$today['year']);
	}

	public static function valid_date($date_str) {  // mm/dd/yyyy -> stamp

	#  Checks user-entered date for valid format.
	#  Date is requested in mm/dd/yyyy format
	#  If user enters a 2 digit year, will convert to 4 digit
	#  Returns Date object, or false if invalid

		//  Initialize errors array
		$errors = array();
		
		//  Make sure date was entered
		if ($date_str == '') {
			$errors[] = 'Event date entry is required';
		}
		
		$components = explode('/', $date_str);
		
		if (count($components) < 3) {
			$errors[] = 'Date is not valid (must be mm/dd/yyyy format)';
			return false;
		}

		// list($month,$day,$year) = explode('/', $date_str);
		$month = $components[0];
		$day = $components[1];
		$year = $components[2];
		
		//  Convert string to an array of month, date, year, and use checkdate() to validate
		if (!checkdate($month,$day,$year)) {
			$errors[] = 'Date is not valid (must be mm/dd/yyyy format)';
		}
		
		$iyear = (int)$year;
		
		if ($iyear < 100) {
			$year = ($iyear > 50) ? ($iyear + 1900) : ($iyear + 2000);
		}
		
		if (empty($errors)) {  
		
			// entry passes validation tests; return date type 
			return new Date($month . "/" . $day . "/"  .$year);
			
		} else {
			
			// Entry is incorrect, return errors array
			return false;
		}
	}
}
?>