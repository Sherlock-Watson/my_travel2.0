<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Sherlock Watson">

    <title>首页</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.7/docs/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap-3.3.7/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap-3.3.7/docs/examples/carousel/carousel.css" rel="stylesheet">
    <link href="css/myCss.css" rel="stylesheet">
</head>

<!-- NAVBAR
================================================== -->
<body>
<div class="navbar-wrapper">
    <div class="container">

        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">首页</a></li>
                        <li><a href="#about">浏览</a></li>
                        <li><a href="#contact">搜索</a></li>
                        <li id="myAccount" class="dropdown">
                            <?php
                            if (isset($_COOKIE['Username'])) {
                                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" 
role="button" aria-haspopup="true" aria-expanded="false">个人中心 <span class="caret"></span></a>
<ul class="dropdown-menu">
                    <li><a href="#"><img src="img/upload.svg" alt="upload" width="20" height="20">上传</a></li>
                    <li><a href="#"><img src="img/image.svg" alt="image" width="20" height="20">我的照片</a></li>
                    <li><a href="#"><img src="img/like_filled.svg" alt="like" width="20" height="20">我的收藏</a></li>
                    <li><a href="php/logout.php"><img src="img/user.svg" alt="logout" width="20" height="20">登出</a></li>
                  </ul>';
                            }
                            else {
                                echo '<a href="logIn.php">登录</a>';
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>


<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img class="first-slide" src="img/Light2.jpg" alt="First slide">
        </div>
        <div class="item">
            <img class="second-slide" src="img/Windmill.jpg" alt="Second slide">

        </div>
        <div class="item">
            <img class="third-slide" src="img/Forest.jpg" alt="Third slide">
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div><!-- /.carousel -->


<!-- Marketing messaging and featurettes
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container marketing">

    <!-- Three columns of text below the carousel -->
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
    for ($i = 0; $i < 12 && $row = $result->fetch(); $i++) {
        array_push($pictures, $row['PATH']);
        array_push($titles, $row['Title']);
        array_push($descriptions, $row['Description']);
    }
    for ($i = 0; $i < 3; $i++) {
        echo '<div class="row">';
        for ($j = 0; $j < 3; $j++) {
            $key = 3 * $i + $j;
            echo '<div class="col-lg-4">
            <img class="img-circle" src="img/travel-images/large/'.$pictures[$key].'" alt="Generic placeholder image" width="140" height="140" id="picture'.$key.'">
            <h2 id="title'.$key.'">'.$titles[$key].'</h2>
            <p class="index-description" id="description'.$key.'">'.$descriptions[$key].'</p>
            <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->';
        }
        echo '</div><!-- /.row -->';
    }
    ?>

    <div class="up-refresh">
        <div class="up">
            <a href="#">
                <img src="img/up.svg" alt="up" width="30" height="30">
            </a>
        </div>
        <div class="refresh">
            <img src="img/refresh.svg" alt="refresh" width="30" height="30" id="refresh">
        </div>
    </div>
    <?php
    $rand = array();
    function isUnique($n, $array) {
        for ($i = 0; $i < $array->count(); $i++) {
            if ($n === $array[$i]) {
                return false;
            }
        }
        return true;
    }

    function getRandNum($max, $array) {
        if (isUnique($ranNum = rand(1, $max), $array)) {
            array_push($array, $ranNum);
            return $ranNum;
        }
        else {
            getRandNum($max, $array);
        }
    }
    $sql2 = "SELECT COUNT(*) AS Num FROM travelimage";
    $result2 = $pdo->query($sql2);
    $row2 = $result2->fetch();
    ?>

    <!-- FOOTER -->
    <footer>
<!--        <p class="pull-right"><a href="#">Back to top</a></p>-->
        <p>&copy; 2016 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>

</div><!-- /.container -->




<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script>
    console.log("hello");
    let refresh = document.getElementById("refresh");
    document.write("hello");
    console.log("hello, "+refresh);
    refresh.onclick = function () {
        console.log('clicked');
        <!--            --><?php
        //echo '<h1>clicked'.getRandNum($row2['Num'], $rand).'</h1>';
        //            ?>
        for (let i = 0; i < 9; i++) {
            let path =
                <?php
                //$sql3 = "SELECT * WHERE ImageID=" . getRandNum($row2['Num'], $rand);
                $sql3 = "SELECT * WHERE ImageID=" . rand(1, 80);
                $result3 = $pdo->query($sql3);
                $row3 = $result3->fetch();
                echo $row3['PATH'];
                ?>;
            let title =
                <?php
                echo $row3['Title'];
                ?>;
            let description =
                <?php
                echo $row3['Description'];
                ?>;
            document.getElementById("picture" + i).setAttribute("src", "img/travel-images/large/" + path);
            document.getElementById("title" + i).innerHTML = title;
            document.getElementById("description" + i).innerHTML = description;
        }
    }
    //     $()
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="bootstrap-3.3.7/docs/assets/js/vendor/jquery.min.js"></script>
<script src="bootstrap-3.3.7/docs/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="bootstrap-3.3.7/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
<script>
    $(document).ready(function(){
        $("#refresh").attr("src", "img/image.svg");
    });
</script>
<script type="text/javascript" src="js/log.js"></script>
</body>
</html>