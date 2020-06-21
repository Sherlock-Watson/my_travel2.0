<?php
require_once 'config.php';
function showResults($sql){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $result = $pdo->query($sql);
    $str = '{"results":[';
    while ($row = $result->fetch()) {
        $picture = preg_replace('/"/','\"',$row['PATH']);
        $title = preg_replace('/"/','\"',$row['Title']);
        $description = preg_replace('/"/','\"',$row['Description']);
        $str.='{"PATH":"'.$picture.'", "Title":"'.$title. '", "Description":"'.$description.'", "ImageID":'.$row['ImageID'].'},';
    }
    if ($str !== '{"results":[') {
        $str = substr($str, 0, strlen($str) - 1);
    }
    $str.=' ]}';
    return $str;
}