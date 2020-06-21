<?php
require_once 'config.php';
$imageID = $_POST['imageID'];
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$sql = "DELETE FROM travelimage WHERE ImageID = " . $imageID . " AND UID = ".$_COOKIE['UID'];
$result = $pdo->query($sql);
echo 'true';
/*$result = $pdo->query($sql);
while ($row = $result->fetch()) {
    $sqlDel = "DELETE FROM travelimage WHERE ImageID = " . $imageID;
    $pdo->query($sqlDel);
    unlink("../img/travel-images/large/" . $row['PATH']);
    echo 'true';
}*/
