<?php

define("DB_HOST", "localhost");
define("DB_USER", "aqms");
define("DB_PASSWORD", "Succ3s!");
define("DB_DATABASE", "aqms");

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE) or die('Unable to Connect');

 ?>
