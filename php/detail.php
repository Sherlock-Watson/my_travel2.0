<?php
require_once 'search.php';
$imageID = $_POST['imageID'];
$sql = "SELECT * FROM travelimage WHERE ImageID = " . $imageID;
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$result = $pdo->query($sql);
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
$sqlFavor = "SELECT travelimage.ImageID, Count(travelimagefavor.UID) AS NumFavor 
FROM travelimage JOIN travelimagefavor ON travelimagefavor.ImageID=travelimage.ImageID
WHERE travelimage.ImageID = ".$imageID."
GROUP BY travelimagefavor.ImageID";
$resultFavor = $pdo->query($sqlFavor);
if ($rowFavor = $resultFavor->fetch()) {
    $favorNum = $rowFavor['NumFavor'];
}
else {
    $favorNum = 0;
}
$sqlAuthor = "SELECT UserName FROM traveluser WHERE UID = ".$row['UID'];
$resultAuthor = $pdo->query($sqlAuthor);
$rowAuthor = $resultAuthor->fetch();
$str = '{"PATH":"'.$picture.'", "Title":"'.$title. '", "Description":"'.$description.
    '", "ImageID":'.$row['ImageID'].',"Country":"'.$rowCountry['Country_RegionName'].
    '","City":"'.$rowCity['AsciiName'].'","Content":"'.$row['Content'].
    '","FavorNum":'.$favorNum.',"UserName":"'.$rowAuthor['UserName'].'"}';
echo $str;