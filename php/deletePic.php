<?php
require_once 'config.php';
$imageID = $_POST['imageID'];
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$sql = "SELECT PATH FROM travelimage WHERE ImageID = " . $imageID;
$result = $pdo->query($sql);
while ($row = $result->fetch()) {
    $sqlDel = "DELETE FROM travelimage WHERE ImageID = " . $imageID;
    $pdo->query($sqlDel);
    unlink("../img/travel-images/large/" . $row['PATH']);
    echo 'true';
}