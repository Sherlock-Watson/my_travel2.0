let url=location.search;
function getStatus(urlStr) {
    let str = urlStr.split(/[?&]/g);
    for (let i = 1; i < str.length; i++) {
        let s = str[i].split(/=/);
        if(s[0] === "logIn") {
            return s[1]==="loggedIn";
        }
    }
    return false;
}

console.log(location.search);
if (getStatus(url)) {
    $(document).ready(function() {
        if (document.cookie != null) {
            $("#myAccount").html("<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" " +
                "aria-haspopup=\"true\" aria-expanded=\"false\">个人中心<span class=\"caret\"></span></a>\n" +
                "                  <ul class=\"dropdown-menu\">\n" +
                "                    <li><a href=\"#\">上传</a></li>\n" +
                "                    <li><a href=\"#\">我的照片</a></li>\n" +
                "                    <li><a href=\"#\">我的收藏</a></li>\n" +
                "                    <li id='logout'><a href=\"http://localhost:63342/Web%20Project%202/php/logout.php\">登出</a></li>\n" +
                "                  </ul>");
        }
    });
}