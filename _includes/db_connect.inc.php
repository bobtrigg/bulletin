<?php 

// include in database params (user, p/w, host, db name)
require ('_includes/db_info.inc.php');

// Connect to database
$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error() . "<br>Host name: " . DB_HOST . "<br>User: " . DB_USER . "<br>Password: " . DB_PASS . "<br>Database name: " . DB_NAME);

?>