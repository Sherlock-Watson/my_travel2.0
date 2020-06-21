<?php
require_once 'config.php';
$country = $_POST['country'];
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$sql = 'SELECT geocities.AsciiName
FROM geocities
JOIN geocountries_regions ON geocountries_regions.ISO = geocities.Country_RegionCodeISO
WHERE geocountries_regions.Country_RegionName = \''.$country.'\'';
$result = $pdo->query($sql);
$city = '{"city":[';
while ($row = $result->fetch()) {
    $city .= '"' . $row['AsciiName'] . '",';
}
if (substr($city, strlen($city) - 1, 1) !== '[') {
    $city = substr($city, 0, strlen($city) - 1);
}
$city .= ']}';
echo $city;