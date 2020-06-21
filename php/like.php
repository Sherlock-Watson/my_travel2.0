<?php
require_once 'search.php';
$uid = $_COOKIE['UID'];
$sql = "SELECT * FROM travelimage
JOIN travelimagefavor ON travelimage.ImageID = travelimagefavor.ImageID
WHERE travelimagefavor.UID = ".$uid;
$str = showResults($sql);
echo $str;
