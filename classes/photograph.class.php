<?php
require_once(LIB_PATH."database.php");

class Photograph extends DatabaseObject {

	protected static $table_name = "photographs";
	protected static $db_fields = array('id','filename','type','size','caption');
	public $id;
	public $filename;
	public $type;
	public $size;
	public $caption;

	// The Photograph class uses several methods defined in the DatabaseObject
	// superclass, including query functions (find_all, find_by_sql, find_by_id) and 
	// CRUD functions (create, update, delete, save).
	
	private $temp_path;             // temp directory where files are uploaded by php
	protected $upload_dir="images"; // final directory for uploaded files
	public $errors=array();         // array of errors to catalog what went wrong
	
	public $upload_errors = array(
		// This array contains upload error codes and their user friendly equivalents.
		// We can use this for reporting errors.
		// In an applicaion, this could be put in a config file
		UPLOAD_ERR_OK => "No errors",
		UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize",
		UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE",
		UPLOAD_ERR_PARTIAL => "Partial upload",
		UPLOAD_ERR_NO_FILE => "No file",
		UPLOAD_ERR_NO_TMP_DIR => "No temporary directory",
		UPLOAD_ERR_CANT_WRITE => "Can't write to disk",
		UPLOAD_ERR_EXTENSION => "File upload stopped by extension"
	);

	public function image_path() {
		return $this->upload_dir."/".$this->filename;
	}
	public function size_as_text() {
		if($this->size < 1024) {
			return "{$this->size} bytes";
		} elseif($this->size < 1048576) {
			$size_kb = round($this->size/1024);
			return "{$size_kb} KB";
		} else {
			$size_mb = round($his->size/1048576,1);
			return "{$size_mb} MB";
		}
	}
	public function comments() {
		return Comment::find_comments_on($this->id);
	}
	public function attach_file($file) {
		// Pass in $_FILE(['uploaded_file'] as an argument
		// Perform error checking on the form parameters
		if(!$file || empty($file) || !is_array($file)) {
			// error: nothing uploaded or wrong argument usage
			$this->errors[] = "No file was uploaded";
			return false;
		} elseif($file['error'] != 0) {
			// error: report what PHP says went wrong
			$this->errors[] = $this->upload_errors[$file['error']];
		} else {
			// Set object attributes to the form parameters
			$this->temp_path = $file['tmp_name'];
			$this->filename = basename($file['name']);
			$this->type = $file['type'];
			$this->size = $file['size'];
		}
		// Don't worry about saving anything to the DB yet.
		return true;
	}
	function save() {
		// Custom save() function overwrites save() function in DatabaseObject class

		// A new record won't have an id yet
		if(isset($this->id)) {
			$this->update();
		} else {

			// Make sure there are no errors

			// Check for pre-existing errors from upload
			if(!empty($this->errors)) {return false;};
			
			// Make sure the caption is not too long
			if(strlen($this->caption) > 255) {
				$this->errors[] = "Caption is longer than 255 characters";
				return false;
			}
			// Check for valid file name and location
			if(empty($this->filename) || empty($this->temp_path)) {
				$this->errors[] = "The file location is not available";
				return false;
			}
			// Define and check the full pathname
			$target_path = SITE_ROOT.'public'.DS.$this->upload_dir.DS.$this->filename;
			if(file_exists($target_path)) {
				$this->errors[] = "The file {$this->filename} already exists";
				return false;
			}
			
			// Attempt to move the file
			if(move_uploaded_file($this->temp_path,$target_path)) {
				// Success - create a corresponding entry in the DB
				if($this->create()) {
					// We're done with temp_path; the file was already moved
					unset($this->temp_path);
					return true;
				}
			} else {
				// File was not moved.
				$this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
				return false;
			}
			$this->create();
		}
	}
	public function destroy($id) {
		// First remove the database entry
		if($this->delete($id)) {
			// then remove the file
			$target_path = SITE_ROOT."public".DS.$this->image_path();
			return unlink($target_path)?true:false;
		} else {
			// database delete failed
			return false;
		}
	}
}
?>