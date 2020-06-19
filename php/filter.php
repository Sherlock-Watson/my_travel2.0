<?php
require_once 'config.php';
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$sqlContent = "SELECT Content FROM `travelimage` GROUP BY Content";
$resContent = $pdo->query($sqlContent);
//$content = array();
$strContent = '"Content":[';
while ($rowContent = $resContent->fetch()) {
    $strContent .= '"'.$rowContent['Content'].'",';
}
$strContent = substr($strContent, 0, strlen($strContent) - 1);
$strContent .= ']';
$sqlCountry = 'SELECT geocountries_regions.Country_RegionName, travelimage.Country_RegionCodeISO
    FROM `travelimage` 
    JOIN geocountries_regions ON geocountries_regions.ISO = travelimage.Country_RegionCodeISO
    GROUP BY travelimage.Country_RegionCodeISO';
$resCountry = $pdo->query($sqlCountry);
$strCountry = '"Country":[';
$strCity = '"City":[';
while ($rowCountry = $resCountry->fetch()) {
    $strCity .= '[';
    $strCountry .= '"'.$rowCountry['Country_RegionName'].'",';
    $sqlCity = 'SELECT geocities.AsciiName, travelimage.CityCode
    FROM travelimage
    JOIN geocities ON geocities.GeoNameID = travelimage.CityCode
    WHERE travelimage.Country_RegionCodeISO = \''.$rowCountry['Country_RegionCodeISO'].'\'
    GROUP BY travelimage.CityCode';
    $resCity = $pdo->query($sqlCity);
    while ($rowCity = $resCity->fetch()) {
        $strCity .= '"'.$rowCity['AsciiName'].'",';
    }
    $strCity = substr($strCity, 0, strlen($strCity) - 1);
    $strCity .= '],';
}
$strCountry = substr($strCountry, 0, strlen($strCountry) - 1);
$strCountry .= ']';
$strCity = substr($strCity, 0, strlen($strCity) - 1);
$strCity .= ']';
echo '{'.$strContent.','.$strCountry.','.$strCity.'}';
