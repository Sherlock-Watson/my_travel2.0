<?php
require_once("config.php");
$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$sql = "SELECT travelimagefavor.ImageID, Count(travelimagefavor.UID) AS NumFavor, travelimage.PATH, travelimage.Title, travelimage.Description  
FROM travelimage JOIN travelimagefavor ON travelimagefavor.ImageID=travelimage.ImageID
GROUP BY travelimagefavor.ImageID 
ORDER BY NumFavor DESC";
$result = $pdo->query($sql);
$pictures = array();
$titles = array();
$descriptions = array();
for ($i = 0; $i < 9 && $row = $result->fetch(); $i++) {
    array_push($pictures, $row['PATH']);
    array_push($titles, $row['Title']);
    array_push($descriptions, $row['Description']);
}
function changePics($pictures, $titles, $descriptions)
{
    for ($i = 0; $i < 3; $i++) {
        echo '<div class="row">';
        for ($j = 0; $j < 3; $j++) {
            $key = 3 * $i + $j;
            echo '<div class="col-lg-4">
            <img class="img-circle" src="img/travel-images/large/' . $pictures[$key] . '" alt="Generic placeholder image" width="140" height="140" id="picture' . $key . '">
            <h2 id="title' . $key . '">' . $titles[$key] . '</h2>
            <p class="index-description" id="description' . $key . '">' . $descriptions[$key] . '</p>
            <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->';
        }
        echo '</div><!-- /.row -->';
    }
}
changePics($pictures, $titles, $descriptions);
$pdo = null;