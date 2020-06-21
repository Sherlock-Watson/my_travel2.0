<?php
require_once("config.php");
function validLogin(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    //very simple (and insecure) check of valid credentials.
    $sql = "SELECT * FROM traveluser WHERE UserName=:username and Pass=:pass";
    $sql1 = "SELECT * FROM traveluser WHERE Email=:email and Pass=:pass";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':username',$_POST['userName']);
    $statement->bindValue(':pass',$_POST['password']);
    $statement->execute();
    $statement1 = $pdo->prepare($sql1);
    $statement1->bindValue(':email',$_POST['userName']);
    $statement1->bindValue(':pass',$_POST['password']);
    $statement1->execute();
    if($statement->rowCount()>0 || $statement1->rowCount()>0){
        if ($statement->rowCount()>0) {
            while ($row = $statement->fetch()) {
                $uid = $row['UID'];
            }
        }
        else if ($statement1->rowCount()>0) {
            while ($row = $statement1->fetch()) {
                $uid = $row['UID'];
            }
        }
        return array(true, $uid);
    }
    return array(false, 0);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = validLogin()[0];
    $uid = validLogin()[1];
    if($valid){
        // add 1 day to the current time for expiry time
        $expiryTime = time()+60*60*24;
        setcookie("Username", $_POST['userName'], $expiryTime);
        setcookie("UID", $uid, $expiryTime);
    }
}
else {
    $uid = null;
}
if (!isset($_COOKIE['Username'])){
    echo false;
}
else{
    echo $uid;
}