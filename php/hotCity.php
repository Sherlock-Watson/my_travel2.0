<?php
require_once 'search.php';
$city = $_POST['City'];
$sql = "SELECT * FROM travelimage
JOIN geocities ON geocities.GeoNameID = travelimage.CityCode
WHERE geocities.AsciiName = '".$city."'";
echo showResults($sql);