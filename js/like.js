$(document).ready(function() {
    let pageSize = 6;
    let totalCount;
    let totalPage;
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
        url: 'php/like.php',
        async: false,
        success: function (data) {
            //console.log(data);
            result = JSON.parse(data).results;
            totalCount = result.length;
            totalPage = (Math.ceil(totalCount / pageSize) > 5)?5:Math.ceil(totalCount / pageSize);
            $('#resultPart').html(showPage(result, 1));
            $('.pages').html(showPageNumber(totalPage));
            $('.page1').addClass('active-page');
        }
    });
    turnPage(result, totalPage);

    for (let i = 0; i < totalCount; i++) {
        $('.' + i).click(function () {
            let imageID = $('.' + i).attr('id');
            $.ajax({
                type: 'POST',
                url: 'php/deleteFavor.php',
                async: false,
                data: {"imageID":imageID},
                data_type: 'json',
                success: function (data) {
                    if (data) {
                        $('.item-content' + i).remove();
                    }
                    else {
                        alert('所选图片并未被删除……');
                    }
                }
            });
        });
    }

    function showPage(res, currentPage) {
        let totalCount = res.length;
        if (totalCount === 0) {
            return '<h1>你还没有收藏任何照片，快去收藏吧！</h1>';
        }
        let mark = (currentPage - 1) * pageSize;
        let left = totalCount - mark;
        let str = '<div class="title"><h5>我的收藏</h5></div>\n' +
            '    <hr>';
        if (left >= pageSize) {
            for (let i = 0; i < pageSize; i++) {
                let key = mark + i;
                str += '<div class="item-content item-content'+key+'">\n' +
                    '        <div class="picture"><a href="detail.html?ImageID=' + res[key].ImageID + '">' +
                    '<div class="target" style="background-image: url(&quot;img/travel-images/large/' + res[key].PATH + '&quot;)"></div>' +
                    '</a></div>\n' +
                    '        <div class="item-text">\n' +
                    '            <h5>' + res[key].Title + '</h5>\n' +
                    '            <p>' + res[key].Description + '</p>\n' +
                    '        </div>\n' +
                    '        <input type="button" value="删除" class="delete '+key+'" id="' + res[key].ImageID + '">' +
                    '<hr>'+
                    '    </div>\n';
            }
        } else {
            for (let i = 0; i < left; i++) {
                let key = mark + i;
                str += '<div class="item-content item-content'+key+'">\n' +
                    '        <div class="picture"><a href="detail.html?ImageID=' + res[key].ImageID + '">' +
                    '<div class="target" style="background-image: url(&quot;img/travel-images/large/' + res[key].PATH + '&quot;)"></div>' +
                    '</a></div>\n' +
                    '        <div class="item-text">\n' +
                    '            <h5>' + res[key].Title + '</h5>\n' +
                    '            <p>' + res[key].Description + '</p>\n' +
                    '        </div>\n' +
                    '        <input type="button" value="删除" class="delete '+key+'" id="' + res[key].ImageID + '">' +
                    '    <hr>' +
                    '    </div>\n';
            }
        }
        return str;
    }

    function showPageNumber(totalPage) {
        if (totalPage !== 0) {
            let str = '' +
                '                <div class="pages-list">\n' +
                '                <ul class="page-ul">\n' +
                '                <li><a class="backward"><<</a></li>\n';
            for (let i = 1; i <= totalPage; i++) {
                str += '<li><a class="page' + i + '">' + i + '</a></li>';
            }
            str += '<li><a class="forward">>></a></li>\n' +
                '                    </ul>\n' +
                '                </div>\n';
            return str;
        }
    }

    function turnPage(res, totalPage) {
        if (totalPage > 0) {
            for (let i = 1; i <= totalPage; i++) {
                $('.page' + i).click(function () {
                    $('#resultPart').html(showPage(res, i));
                    let index = findActivePage(totalPage);
                    $('.page' + index).removeClass('active-page');
                    $('.page' + i).addClass('active-page');
                });
            }
            $('.backward').click(function () {
                let index = findActivePage(totalPage);
                let prePage = (index - 1 > 0) ? (index - 1) : totalPage;
                $('.page' + prePage).click();
            });
            $('.forward').click(function () {
                let index = findActivePage(totalPage);
                let nextPage = (totalPage - index > 0) ? (index + 1) : 1;
                $('.page' + nextPage).click();
            });
        }
    }

    function findActivePage(totalPage) {
        for (let i = 1; i <= totalPage; i++) {
            if ($('.page'+i).hasClass("active-page")) {
                return i;
            }
        }
    }
});