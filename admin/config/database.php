<?php
require 'constants.php';
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'providence-log');

$con =mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    echo "Connection Error: " . mysqli_connect_error($con);
}