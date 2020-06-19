<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css" media="all">
    <link rel="stylesheet" type="text/css" href="css/LogIn.css" media="all">
    <link rel="stylesheet" type="text/css" href="css/myCss.css" media="all">
</head>
<body>
<header>
    <img src="img/user-login.svg" alt="Log in" width="70" height="70">
</header>

<?php
/*function getLogForm() {
    return'
    <form name="logIn" method="post" action="">
            <p>
                <label for="userName">用户名/邮箱：</label>
                <input type="text" id="userName" name="userName" value="" placeholder="用户名/邮箱">
            </p>
            <p>
                <label for="password">密码：</label>
                <input type="password" id="password" name="password">
            </p>
            <!--<p id="logInError" class="alert alert-danger"></p>-->
            <p>
                <input type="submit" value="登录" name="logIn">
            </p>
        </form>
    ';
}
*/?><!--
--><?php
/*   require_once("config.php");
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
//$logIn = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = validLogin()[0];
    $uid = validLogin()[1];
    echo '<h1>'.$uid.'</h1>';
    if($valid){
        // add 1 day to the current time for expiry time
        $expiryTime = time()+60*60*24;
        setcookie("Username", $_POST['userName'], $expiryTime);
    }
}
else {
    $uid = null;
}
*/?>
<div class="contents">
    <div id="title"><h2>登录My Travel</h2></div>
    <div class="form">
        <?php
/*        if (!isset($_COOKIE['Username'])){
            echo getLogForm();
        }
        else{
            echo '<h1>'.$uid.'</h1>';
            $url = "Location:../index.php?logIn=".$uid;
            echo '<h1>'.$url.'</h1>';

            header($url);
        }
        */?>
        <form name="logIn" method="post" action="php/logInProcess.php">
            <p>
                <label for="userName">用户名/邮箱：</label>
                <input type="text" id="userName" name="userName" value="" placeholder="用户名/邮箱">
            </p>
            <p>
                <label for="password">密码：</label>
                <input type="password" id="password" name="password">
            </p>
            <p>
                <input type="submit" value="登录" name="logIn">
            </p>
        </form>
    </div>
    <div class="register-invitation">
        还没有My Travel的账号？<a href="register.php">注册一个吧</a>
    </div>
</div>

<footer class="myFooter">
    Copyright &copy; 2019-2021 May the force be with you. All Rights Reserved. 备案号浙FORCE备19930号-9
</footer>
</body>
</html>