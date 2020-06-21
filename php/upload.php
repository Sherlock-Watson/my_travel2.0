<?php
require_once 'config.php';
/*echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"];*/
/*print_r($_POST);
print_r($_FILES);
print_r($_COOKIE);*/
$upload = false;
if ($_FILES["file0"]["error"] > 0)
{
    $upload = false;
}
else
{
    /*echo "上传文件名: " . $_FILES["file0"]["name"] . "<br>";
    echo "文件类型: " . $_FILES["file0"]["type"] . "<br>";
    echo "文件大小: " . ($_FILES["file0"]["size"] / 1024) . " kB<br>";
    echo "文件临时存储的位置: " . $_FILES["file0"]["tmp_name"] . "<br>";*/

    // 判断当前目录下的 upload 目录是否存在该文件
    // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
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
}
function validUpload($upload) {
    $description = preg_replace("/'/", "\'", $_POST['description']);
    if ($upload) {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $sqlCity = "SELECT GeoNameID FROM geocities WHERE AsciiName = '" . $_POST['city'] . "'";
        $resultCity = $pdo->query($sqlCity);
        $rowCity = $resultCity->fetch();
        //$statement->bindValue(':cityCode', $rowCity['GeoNameID']);
        $sqlCountry = "SELECT ISO FROM geocountries_regions WHERE Country_RegionName = '" . $_POST['country'] . "'";
        $resultCountry = $pdo->query($sqlCountry);
        $rowCountry = $resultCountry->fetch();
        //$statement->bindValue(':ISO', $rowCountry['ISO']);
        $sql = "INSERT INTO travelimage (Title, Description, Latitude, Longitude, CityCode, Country_RegionCodeISO, UID, PATH, Content)
VALUES ('".$_POST['title']."', '".$description."', 51.061249, -114.082136, '".$rowCity['GeoNameID']."', '".$rowCountry['ISO'].
            "', '".$_COOKIE['UID']."', '".$_FILES["file0"]["name"]."', '".$_POST['content']."')";
        $pdo->query($sql);
        return true;
    } else {
        return false;

    }
}

if (validUpload($upload)) {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $sql = "SELECT ImageID FROM travelimage WHERE PATH = '".$_FILES["file0"]["name"]."'";
    $result = $pdo->query($sql);
    $row = $result->fetch();
    echo $row['ImageID'];
}
else if ($upload === false) {
    echo 'file existed';
}