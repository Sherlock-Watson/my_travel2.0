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
} else {
    echo '<a href="logIn.php">登录</a>';
}
