<?php
#  item.class.php - bulletin item class definition
#  Created May, 2012, by Bob Trigg

require_once('classes/table.class.php');

class Item extends Table {

	protected $data_array;

######  Constructor function creates a new bulletin item
######  function assigns primary key value and an array of other column values, then calls parent (table) constructor
	
	public function __construct($bulletin_date=NULL, 
								$position=NULL, 
								$title=NULL, 
								$subtitle=NULL, 
								$content=NULL, 
								$excerpt=NULL, 
								// $caption=NULL, 
								$graphic=NULL,
								$alt_text=NULL,
								$thumbnail=NULL,
								$item_id=NULL	) 
	{
		$this->pk_id = (int)$item_id;
		
		$this->data_array = array('bulletin_date' => $bulletin_date, 
								  'position' => (int)$position,
								  'title' => (string)$title,
								  'subtitle' => $subtitle,
								  'content' => (string)$content,
								  'excerpt' => (string)$excerpt,
								  //'caption' => (string)$caption,
								  'graphic' => $graphic,
								  'alt_text' => $alt_text,
								  'thumbnail' => $thumbnail
								  );
								  
		parent::__construct('items', 'item_id', 
		                     array('bulletin_date', 'position','title','subtitle','content',
							       'excerpt'/*,'caption'*/,'graphic','alt_text','thumbnail'));
	}
}
?>