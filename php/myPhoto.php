<?php
require_once 'search.php';
$uid = $_COOKIE['UID'];
$sql = "SELECT * FROM travelimage WHERE UID = ".$uid;
$str = showResults($sql);
echo $str;
