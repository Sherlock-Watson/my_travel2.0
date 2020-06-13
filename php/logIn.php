<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/LogIn.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/myCss.css" media="all">
</head>
<body>
<header>
    <img src="../img/user-login.svg" alt="Log in" width="70" height="70">
</header>

<?php
function getLogInForm() {
    echo'
    <form name="logIn" method="post" action="../php/logIn.php">
            <p>
                <label for="userName">用户名：</label>
                <input type="text" id="userName" name="userName" value="" placeholder="用户名">
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
?>
<h1>
<?php
   require_once("config.php");
function validLogin(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    //very simple (and insecure) check of valid credentials.
    $sql = "SELECT COUNT(*) FROM users WHERE Username=:username and Password=:pass";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':username',$_POST['userName']);
    $statement->bindValue(':pass',$_POST['password']);
    $statement->execute();
//    if ($statement->rowCount()===0) {
//        echo '
//        <script type="text/javascript">
//        document.getElementById("logInError").innerHTML = "用户名或密码输入不正确";
//</script>
//        ';
//    }
    if($statement->rowCount()>0){
        return true;
    }
    return false;
}
//$logIn = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(validLogin()){
        // add 1 day to the current time for expiry time
        $expiryTime = time()+60*60*24;
        setcookie("Username", $_POST['userName'], $expiryTime);
    }
//    else {
//        echo '<h1>没有正常登录</h1>';
//        echo '
//        <script type="text/javascript">
//        document.getElementById("logInError").innerHTML = "用户名或密码输入不正确";
//</script>
//        ';
//    }
}
else echo 'No post';

?>
</h1>
<div class="contents">
    <div id="title"><h2>登录My Travel</h2></div>
    <div class="form">
        <?php
        if (!isset($_COOKIE['Username'])){
            echo getLoginForm();
        }
        else{
            echo '
            <script type="text/javascript">
            window.location.href="../index.html?logIn=" + escape("loggedIn");
            </script>
            ';
        }
        ?>
    </div>
    <div class="register-invitation">
        还没有My Travel的账号？<a href="http://localhost:63342/Web%20Project%202/php/register.php">注册一个吧</a>
    </div>
</div>

<footer class="myFooter">
    Copyright &copy; 2019-2021 May the force be with you. All Rights Reserved. 备案号浙FORCE备19930号-9
</footer>
</body>
</html>