$(document).ready(function() {
    let pageSize = 6;
    let totalCount;
    let totalPage;
    $.ajax({
        type: 'POST',
        url: 'php/myAccount.php',
        async: false,
        success: function (data) {
            $('.myAccount').html(data);
        }
    });

    $('#btnSearch').click(function () {
        let radios = document.getElementsByName('filter-by-title-or-description');
        let searchContent;
        let result;
        if (radios[0].checked) {
            searchContent = $('#searchTitle').val();
            if (searchContent) {
                $.ajax({
                    type: 'POST',
                    url: 'php/searchByTitle.php',
                    async: false,
                    data: {'searchContent': searchContent},
                    data_type: 'json',
                    success: function (data) {
                        result = JSON.parse(data).results;
                        totalCount = result.length;
                        totalPage = (Math.ceil(totalCount / pageSize) > 5)?5:Math.ceil(totalCount / pageSize);
                        $('#resultPart').html(showPage(result, 1));
                        $('.pages').html(showPageNumber(totalPage));
                        $('.page1').addClass('active-page');
                    }
                });
                turnPage(result, totalPage);
            }
            else {
                $('#resultPart').html('<h1>你什么都没有输入……</h1>');
            }
        }
        else {
            searchContent = $('#description').val();
            if (searchContent) {
                $.ajax({
                    type: 'POST',
                    url: 'php/searchByDescription.php',
                    async: false,
                    data: {'searchContent': searchContent},
                    data_type: 'json',
                    success: function (data) {
                        result = JSON.parse(data).results;
                        totalCount = result.length;
                        totalPage = (Math.ceil(totalCount / pageSize) > 5)?5:Math.ceil(totalCount / pageSize);
                        $('#resultPart').empty().html(showPage(result, 1));
                        $('.pages').empty().html(showPageNumber(totalPage));
                        $('.page1').addClass('active-page');
                    }
                });
                turnPage(result, totalPage);
            }
            else {
                $('#resultPart').html('<h1>你什么都没有输入……</h1>');
            }
        }
    });

    function showPage(res, currentPage) {
        let totalCount = res.length;
        if (totalCount === 0) {
            return '<h1>没有搜索到任何结果……</h1>';
        }
        let mark = (currentPage - 1) * pageSize;
        let left = totalCount - mark;
        let str = '<div class="title"><h5>结果</h5></div>\n' +
            '    <hr>';
        if (left >= pageSize) {
            for (let i = 0; i < pageSize; i++) {
                let key = mark + i;
                str += '<div class="item-content">\n' +
                    '        <div class="picture"><a href="detail.html?ImageID=' + res[key].ImageID + '">' +
                    '<div class="target" style="background-image: url(&quot;img/travel-images/large/' + res[key].PATH + '&quot;)"></div>' +
                    '</a></div>\n' +
                    '        <div class="item-text">\n' +
                    '            <h5>' + res[key].Title + '</h5>\n' +
                    '            <p>' + res[key].Description + '</p>\n' +
                    '        </div>\n' +
                    '    <hr>' +
                    '    </div>\n';
            }
        } else {
            for (let i = 0; i < left; i++) {
                let key = mark + i;
                str += '<div class="item-content">\n' +
                    '        <div class="picture"><a href="detail.html?ImageID='+res[key].ImageID+'">' +
                    '<div class="target" style="background-image: url(&quot;img/travel-images/large/' + res[key].PATH + '&quot;)"></div>' +
                    '</a></div>\n' +
                    '        <div class="item-text">\n' +
                    '            <h5>' + res[key].Title + '</h5>\n' +
                    '            <p>' + res[key].Description + '</p>\n' +
                    '        </div>\n' +
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