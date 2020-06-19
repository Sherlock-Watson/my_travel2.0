<?php
require_once("config.php");
$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$rand = array();
function isUnique($n, $array) {
    for ($i = 0; $i < count($array); $i++) {
        if ($n === $array[$i]) {
            return false;
        }
    }
    return true;
}

function getRandNum($max, $array) {
    if (isUnique($ranNum = rand(1, $max), $array)) {
        array_push($array, $ranNum);
        return $ranNum;
    }
    else {
        getRandNum($max, $array);
    }
}
$sql2 = "SELECT COUNT(*) AS Num FROM travelimage";
$result2 = $pdo->query($sql2);
$row2 = $result2->fetch();
$pictures1 = array();
$titles1 = array();
$descriptions1 = array();
for ($i = 0; $i < 9;$i++) {
    $sql3 = "SELECT * FROM travelimage WHERE ImageID=" . $n = getRandNum($row2['Num'], $rand);
    $result3 = $pdo->query($sql3);
    $row3 = $result3->fetch();
    array_push($pictures1, $row3['PATH']);
    array_push($titles1, $row3['Title']);
    array_push($descriptions1, $row3['Description']);
}
for ($i = 0; $i < 3; $i++) {
    echo '<div class="row">';
    for ($j = 0; $j < 3; $j++) {
        $key = 3 * $i + $j;
        echo '<div class="col-lg-4">
            <img class="img-circle" src="img/travel-images/large/' . $pictures1[$key] . '" alt="Generic placeholder image" width="140" height="140" id="picture' . $key . '">
            <h2 id="title' . $key . '">' . $titles1[$key] . '</h2>
            <p class="index-description" id="description' . $key . '">' . $descriptions1[$key] . '</p>
            <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->';
    }
    echo '</div><!-- /.row -->';
}
$pdo = null;