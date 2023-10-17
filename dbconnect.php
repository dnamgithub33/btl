<?php
define('DB_HOST', '103.197.185.151');
define('DB_NAME', 'dangnam1');
define('DB_USER', 'nam');
define('DB_PASSWORD', '');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db = mysqli_select_db($con, DB_NAME) or die("Failed to connect to MySQL: " . mysql_error());
?>
