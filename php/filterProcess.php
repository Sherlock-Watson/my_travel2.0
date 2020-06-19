<?php
require_once 'search.php';
$content = $_POST['Content'];
$city = $_POST['City'];
$sql = "SELECT * FROM travelimage
JOIN geocities ON geocities.GeoNameID = travelimage.CityCode
WHERE travelimage.Content='".$content."' AND geocities.AsciiName='".$city."'";
echo showResults($sql);
