<?php
require_once 'config.php';

function validModify() {
    $description = preg_replace("/'/", "\'", $_POST['description']);
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $sqlCity = "SELECT GeoNameID FROM geocities WHERE AsciiName = '" . $_POST['city'] . "'";
    $resultCity = $pdo->query($sqlCity);
    $rowCity = $resultCity->fetch();
    $sqlCountry = "SELECT ISO FROM geocountries_regions WHERE Country_RegionName = '" . $_POST['country'] . "'";
    $resultCountry = $pdo->query($sqlCountry);
    $rowCountry = $resultCountry->fetch();
    if ($_FILES["file0"]["error"] > 0) {
        $sql = "UPDATE travelimage
SET Title = '".$_POST['title']."', Description = '".$description."', CityCode = ".$rowCity['GeoNameID'].", Country_RegionCodeISO = '".$rowCountry['ISO']."', Content = '".$_POST['content']."'
WHERE ImageID = ".$_POST['imageID'];
        $pdo->query($sql);
        return true;
    }
    else {
        $sqlFile = "SELECT PATH FROM travelimage WHERE ImageID = ".$_POST['imageID'];
        $resultFile = $pdo->query($sqlFile);
        $rowFile = $resultFile->fetch();
        unlink("../img/travel-images/large/" . $rowFile['PATH']);
        if (file_exists("../img/travel-images/large/" . $_FILES["file0"]["name"]))
        {
            $upload = false;
        }
        else
        {
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            move_uploaded_file($_FILES["file0"]["tmp_name"], "../img/travel-images/large/" . $_FILES["file0"]["name"]);
            $upload = true;
        }
        if ($upload) {
            $sql = "UPDATE travelimage
SET Title = '".$_POST['title']."', Description = '".$description."', CityCode = ".$rowCity['GeoNameID'].", Country_RegionCodeISO = '".$rowCountry['ISO']."', Content = '".$_POST['content']."', PATH = '".$_FILES["file0"]["name"]."'
WHERE ImageID = ".$_POST['imageID'];
            $pdo->query($sql);
            return true;
        }
        else {
            return false;
        }

    }
}

if (validModify()) {
    echo $_POST['imageID'];
}