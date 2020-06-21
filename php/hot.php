<?php
require_once 'config.php';
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$sqlHotCountry = "SELECT geocountries_regions.Country_RegionName, COUNT(travelimage.ImageID) AS Num
FROM travelimage
JOIN geocountries_regions ON geocountries_regions.ISO = travelimage.Country_RegionCodeISO
GROUP BY geocountries_regions.Country_RegionName
ORDER BY Num DESC
LIMIT 4";
$resultCountry = $pdo->query($sqlHotCountry);
$strHotCountry = '"hotCountry":[';
while ($row = $resultCountry->fetch()) {
    $strHotCountry .= '"'.$row['Country_RegionName'].'",';
}
$strHotCountry = substr($strHotCountry, 0, strlen($strHotCountry)- 1);
$strHotCountry .= ']';
$sqlHotCity = "SELECT geocities.AsciiName, COUNT(travelimage.ImageID) AS Num
FROM travelimage
JOIN geocities ON geocities.GeoNameID = travelimage.CityCode
GROUP BY geocities.AsciiName
ORDER BY Num DESC
LIMIT 4";
$resultCity = $pdo->query($sqlHotCity);
$strHotCity = '"hotCity":[';
while ($row = $resultCity->fetch()) {
    $strHotCity .= '"'.$row['AsciiName'].'",';
}
$strHotCity = substr($strHotCity, 0, strlen($strHotCity) - 1);
$strHotCity .= ']';
$sqlHotContent = "SELECT Content, COUNT(ImageID) AS Num
FROM travelimage
GROUP BY Content
ORDER BY Num DESC
LIMIT 1";
$resultContent = $pdo->query($sqlHotContent);
$strHotContent = '"Content":[';
while ($row = $resultContent->fetch()) {
    $strHotContent .= '"'.$row['Content'].'",';
}
$strHotContent = substr($strHotContent, 0, strlen($strHotContent) - 1);
$strHotContent .= ']';
echo '{'.$strHotCountry.','.$strHotCity.','.$strHotContent.'}';