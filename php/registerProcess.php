<?php
require_once("config.php");
$validPass = false;
function validRegister() {
    $validPass = $_POST['password'] === $_POST['rePassword'];
    if ($validPass) {
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
$register = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (validRegister()) {
        $register = true;
    }
}
if (!$register){
    header('Location:'.$_SERVER['HTTP_REFERER']);
}
else{
    header('Location: logIn.php');
}