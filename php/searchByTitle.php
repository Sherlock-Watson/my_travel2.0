<?php
require_once 'search.php';
$searchContent = $_POST['searchContent'];
$sql = "SELECT * FROM travelimage WHERE Title LIKE '%" . $searchContent . "%'";
$str = showResults($sql);
echo $str;