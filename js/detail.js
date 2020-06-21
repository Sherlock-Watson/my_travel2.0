$(document).ready(function() {
    let imageID = getQueryVariable('ImageID');
    let result;
    $.ajax({
        type: 'POST',
        url: 'php/myAccount.php',
        async: false,
        success: function (data) {
            $('.myAccount').html(data);
        }
    });

    $.ajax({
        type: 'POST',
        url: 'php/detail.php',
        async: false,
        data: {"imageID":imageID},
        data_type: 'json',
        success: function (data) {
            result = JSON.parse(data);
        }
    });

    $('#title').html(result.Title);
    $('#author').html('by ' + result.UserName);
    $('#picture').attr('src', 'img/travel-images/large/' + result.PATH);
    $('#content').html(result.Content);
    $('#country').html(result.Country);
    $('#city').html(result.City);
    $('#description').html(result.Description);
    $('#like-number-number').html(result.FavorNum);

    $('#like').click(function () {
        $.ajax({
            type: 'POST',
            async: false,
            url: 'php/likePic.php',
            data: {"imageID":imageID},
            data_type: 'json',
            success: function (data) {
                if (data === 'not log in yet') {
                    alert('请先登录');
                }
                else if (data === 'had record') {
                    alert('你已经收藏过这张图片。');
                }
                if (data) {
                    alert('已收藏！');
                }
            }
        })
    });

    function getQueryVariable(variable)
    {
        let query = window.location.search.substring(1);
        let vars = query.split("&");
        for (let i=0;i<vars.length;i++) {
            let pair = vars[i].split("=");
            if(pair[0] === variable) {
                return pair[1];
            }
        }
        return false;
    }
});