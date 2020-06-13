<html lang="en">
<body>
<?php
setcookie("Username", "", -1);
if(isset($_COOKIE['Username'])) {
    echo "<h1>还没登出呢</h1>";
}
else {
    echo "<h1>正在跳转……</h1>";
}
?>
<script>
    window.location.href="http://localhost:63342/Web%20Project%202/php/logIn.php";
</script>
</body>
</html>