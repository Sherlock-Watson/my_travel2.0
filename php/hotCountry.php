<?php
require_once 'search.php';
$country = $_POST['Country'];
$sql = "SELECT * FROM travelimage
JOIN geocountries_regions ON geocountries_regions.ISO = travelimage.Country_RegionCodeISO
WHERE geocountries_regions.Country_RegionName = '".$country."'";
echo showResults($sql);