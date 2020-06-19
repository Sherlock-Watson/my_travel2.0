<?php
require_once 'search.php';
$content = $_POST['Content'];
$sql = "SELECT * FROM travelimage
WHERE Content = '".$content."'";
echo showResults($sql);