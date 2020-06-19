<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css" media="all">
    <link rel="stylesheet" type="text/css" href="css/Register.css" media="all">
    <link rel="stylesheet" type="text/css" href="css/myCss.css" media="all">

</head>
<body>
<header>
    <img src="img/user-login.svg" alt="Log in" width="70" height="70">
</header>
<?php
/*require_once("config.php");
function getRegisterForm() {
    return'
    <form action="" method="post" name="register">
            <p>
                <label for="userName">请填写您的用户名：</label>
                <input type="text" name="userName" value="" placeholder="用户名" required maxlength="20">
            </p>
            <p>
                <label for="email">请填写您的邮箱：</label>
                <input type="email" name="email" value="" placeholder="邮箱" required pattern="/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/">
            </p>
            <p>
                <label for="password">请设置您的密码：</label>
                <input type="password" name="password" required minlength="8" id="password">
            </p>
            <p>
                <label for="rePassword">请确认您的密码：</label>
                <input type="password" name="rePassword" required id="rePassword">
            </p>
            <p id="errorMessageArea" class="alert alert-danger"></p>
            <p>
               <div class="logIN-button"><input type="submit" value="注册" name="register"></div>
            </p>
        </form>
    ';
}

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
*/?><!--

    --><?php
/*    $register = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (validRegister()) {
            $register = true;
        }
    }

    */?>

<div class="contents">
    <div id="title"><h2>创建My Travel的账户</h2></div>
    <div class="form" id="registerForm">
        <?php
/*        if (!$register){
            echo getRegisterForm();
            echo '
            <script type="text/javascript" src="../js/register.js"></script>';
        }
        else{
            echo '
            <script type="text/javascript">
            window.location.href="logIn.php";
            </script>
            ';
        }
        */?>
        <form action="" method="post" name="register">
            <p>
                <label for="userName">请填写您的用户名：</label>
                <input type="text" name="userName" value="" placeholder="用户名" required maxlength="20">
            </p>
            <p>
                <label for="email">请填写您的邮箱：</label>
                <input type="email" name="email" value="" placeholder="邮箱" required pattern="/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/">
            </p>
            <p>
                <label for="password">请设置您的密码：</label>
                <input type="password" name="password" required minlength="8" id="password">
            </p>
            <p>
                <label for="rePassword">请确认您的密码：</label>
                <input type="password" name="rePassword" required id="rePassword">
            </p>
            <p id="errorMessageArea" class="alert alert-danger"></p>
            <div class="logIN-button"><input type="submit" value="注册" name="register"></div>
        </form>
    </div>
</div>
<footer>
    Copyright &copy; 2019-2021 May the force be with you. All Rights Reserved. 备案号浙FORCE备19930号-9
</footer>
<script type="text/javascript" src="js/register.js"></script>';
</body>
</html>
