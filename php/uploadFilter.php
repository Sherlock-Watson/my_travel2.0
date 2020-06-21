<?php
require_once 'config.php';
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$sqlCountry = 'SELECT Country_RegionName, ISO FROM geocountries_regions';
$resCountry = $pdo->query($sqlCountry);
$strCountry = '"Country":[';
while ($rowCountry = $resCountry->fetch()) {
//$strCity .= '[';
$strCountry .= '"'.$rowCountry['Country_RegionName'].'",';
/*$sqlCity = 'SELECT AsciiName
FROM  geocities
WHERE Country_RegionCodeISO = \''.$rowCountry['ISO'].'\'';
$resCity = $pdo->query($sqlCity);
while ($rowCity = $resCity->fetch()) {
$strCity .= '"'.$rowCity['AsciiName'].'",';
}
if (substr($strCity, strlen($strCity) - 1, 1) !== '[') {
    $strCity = substr($strCity, 0, strlen($strCity) - 1);
}*/
}
$strCountry = substr($strCountry, 0, strlen($strCountry) - 1);
$strCountry .= ']';
/*$strCity = substr($strCity, 0, strlen($strCity) - 1);
$strCity .= ']';*/
echo '{'.$strCountry.'}';


