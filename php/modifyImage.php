<?php
require_once 'config.php';
$imageID = $_POST['ImageID'];
$sql = "SELECT * FROM travelimage WHERE ImageID = " . $imageID;
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$result = $pdo->query($sql);
//$str = '{"results":[ ';
$row = $result->fetch();
$picture = preg_replace('/"/','\"',$row['PATH']);
$title = preg_replace('/"/','\"',$row['Title']);
$description = preg_replace('/"/','\"',$row['Description']);
$sqlCountry = "SELECT Country_RegionName FROM geocountries_regions WHERE ISO = '".$row['Country_RegionCodeISO']."'";
$resultCountry = $pdo->query($sqlCountry);
$rowCountry = $resultCountry->fetch();
$sqlCity = "SELECT AsciiName FROM geocities WHERE GeoNameID = ".$row['CityCode'];
$resultCity = $pdo->query($sqlCity);
$rowCity = $resultCity->fetch();
$str = '{"PATH":"'.$picture.'", "Title":"'.$title. '", "Description":"'.$description.
    '", "ImageID":'.$row['ImageID'].',"Country":"'.$rowCountry['Country_RegionName'].
    '","City":"'.$rowCity['AsciiName'].'","Content":"'.$row['Content'].'"}';
//$str = substr($str,0,strlen($str) - 1);
//$str.=' ]}';
echo $str;