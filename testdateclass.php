<?php

include ('classes/date.class.php');

$today = new Date('4/1/07');
echo "Today is " . $today->get_display_date() . " or " . $today->get_db_date();


?>