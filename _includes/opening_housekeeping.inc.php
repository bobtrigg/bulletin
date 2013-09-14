<?php

session_start();

//  Set time zone for Bob's house...NOT in L.A.
date_default_timezone_set('America/Los_Angeles');

// Include item class (and table class)
require_once('classes/item.class.php');

//  Include runtime parameters
include_once('_includes/runtime_parms.inc.php');

// include database, validation, and general functions
require_once('_includes/db_functions.inc.php');
require_once('_includes/item_validate.inc.php');
require_once('_includes/functions.inc.php');

$errors = array();

?>