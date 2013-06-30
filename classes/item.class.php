<?php
#  item.class.php - bulletin item class definition
#  Created May, 2012, by Bob Trigg

require_once('classes/table.class.php');

class Item extends Table {

	protected $pk_id;
	protected $data_array;

######  Constructor function creates a new bulletin item
######  function assigns primary key value and an array of other column values, then calls parent (table) constructor
	
	public function __construct($bulletin_date, 
								$position, 
								$title=NULL, 
								$subtitle=NULL, 
								$content=NULL, 
								$excerpt=NULL, 
								// $image=NULL, 
								// $caption=NULL, 
								// $image_link_url=NULL
								$item_id=NULL	) 
	{
		$this->pk_id = (int)$item_id;
		
		$this->data_array = array('bulletin_date' => $bulletin_date, 
								  'position' => (int)$position,
								  'title' => (string)$title,
								  'subtitle' => $subtitle,
								  'content' => (string)$content,
								  'excerpt' => (string)$excerpt,
								  //'image' => (string)$image,
								  //'caption' => (string)$caption,
								  //'image_link_url' => $image_link_url
								  );
								  
		parent::__construct('items', 'item_id', 
		                     array('bulletin_date', 'position','title','subtitle','content',
							       'excerpt'/*,'image','caption','image_link_url'*/));
	}
}
?>