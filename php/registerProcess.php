<?php
require_once("config.php");
function validRegister() {
    if (validUseName($_POST['userName'])) {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        //very simple (and insecure) check of valid credentials.
        $sql = "INSERT INTO traveluser (UserName, Pass, Email, State, DateJoined, DateLastModified)
VALUES (:username, :pass, :email, 1, :dateJoined, :dateLastModified)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':username', $_POST['userName']);
        $statement->bindValue(':pass', $_POST['password']);
        $statement->bindValue(':email', $_POST['email']);
        $statement->bindValue(':dateJoined', date("Y-m-d H:i:s"));
        $statement->bindValue(':dateLastModified', date("Y-m-d H:i:s"));
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return true;
        }
    }
    return false;
}

function validUseName($userName) {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $sql = "SELECT UserName FROM traveluser WHERE UserName=:userName";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':userName', $userName);
    $statement->execute();
    return !($statement->rowCount() > 0);
}
$strValidUserName = false;
$register = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (validRegister()) {
        $strValidUserName = true;
        $register = true;
    }
    else {
        $strValidUserName = validUseName($_POST['userName']);
    }
}
if ($strValidUserName) {
    $strValidUserName = 'true';
}
else {
    $strValidUserName = 'false';
}
if ($register) {
    $register = 'true';
}
else {
    $register = 'false';
}
echo '{"validUserName":'.$strValidUserName.',"validRegister":'.$register.'}';