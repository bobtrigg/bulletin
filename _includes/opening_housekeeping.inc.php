<?php

session_start();

// Include item class (and table class)
require_once('classes/item.class.php');

// include database, validation, and general functions
require_once('_includes/db_functions.inc.php');
require_once('_includes/item_validate.inc.php');
require_once('_includes/functions.inc.php');

$errors = array();

?>