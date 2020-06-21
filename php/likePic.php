<?php
require_once 'config.php';
$imageID = $_POST['imageID'];
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$sqlExist = "SELECT * FROM travelimagefavor WHERE ImageID = ".$imageID." AND UID = ".$_COOKIE['UID'];
if (isset($_COOKIE['Username'])) {
    $sqlExist = "SELECT * FROM travelimagefavor WHERE ImageID = ".$imageID." AND UID = ".$_COOKIE['UID'];
    $result = $pdo->query($sqlExist);
    $row = $result->fetch();
    if (!$row) {
        $sql = "INSERT INTO travelimagefavor (UID, ImageID)
VALUES ('" . $_COOKIE['UID'] . "', '" . $imageID . "')";
        $pdo->query($sql);
        echo 'true';
    }
    else {
        echo 'had record';
    }
}
else {
    echo 'not log in yet';
}