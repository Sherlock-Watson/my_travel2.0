$(document).ready(function() {
    let pageSize = 16;
    let rowPerPage = 4;
    let rowSize = 4;
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

    $('#search').click(function () {
        let searchContent = $('#search-area').val();
        let searchResults;
        if (searchContent) {
            $.ajax({
                type: 'POST',
                url: 'php/searchByTitle.php',
                async: false,
                data: {'searchContent': searchContent},
                data_type: 'json',
                success: function (data) {
                    searchResults = JSON.parse(data).results;
                    totalCount = searchResults.length;
                    totalPage = Math.ceil(totalCount / pageSize);
                    $('#picArea').html(showPage(searchResults, 1));
                    $('.pages').html(showPageNumber(totalPage));
                    $('.page1').addClass('active-page');
                }
            });
            turnPage(searchResults, totalPage);
        }
        else {
            $('#picArea').html('<h1>你什么都没有输入……</h1>');
        }
    });
    let filter;

    $.ajax({
        type: 'POST',
        url: 'php/filter.php',
        async: false,
        success: function (data) {
            filter = JSON.parse(data);
            $('#contents').html(fillContents(filter.Content));
            $('#country').html(fillCountries(filter.Country));
        }
    });

    $('#country').change(function () {
        $('#city').html(fillCity($('#country').val(), filter.City));
    });

    $('#btnFilter').click(function () {
        let filterResults;
        let content = $('#contents').val();
        let city = $('#city').val();
        console.log(content);
        console.log(city);
        if (content === 'default' || city === 'default') {
            $('#picArea').html('<h1>还没选呢不能筛选！</h1>');
        }
        else {
            $.ajax({
                type: 'POST',
                url: 'php/filterProcess.php',
                async: false,
                data: {"Content": content, "City": city},
                data_type: 'json',
                success: function (data) {
                    filterResults = JSON.parse(data).results;
                    totalCount = filterResults.length;
                    totalPage = Math.ceil(totalCount / pageSize);
                    $('#picArea').html(showPage(filterResults,1));
                    $('.pages').html(showPageNumber(totalPage));
                    $('.page1').addClass('active-page');
                }
            });
            turnPage(filterResults, totalPage);
        }
    });

    for (let i = 0; i < 4; i++) {
        $('.country' + i).click(function () {
            let country = $('.country' + i).html();
            console.log(country);
            let searchResults;
            $.ajax({
                type: 'POST',
                url: 'php/hotCountry.php',
                async: false,
                data: {"Country": country},
                data_type: 'json',
                success: function (data) {
                    searchResults = JSON.parse(data).results;
                    totalCount = searchResults.length;
                    totalPage = Math.ceil(totalCount / pageSize);
                    $('#picArea').html(showPage(searchResults, 1));
                    $('.pages').html(showPageNumber(totalPage));
                    $('.page1').addClass('active-page');
                }
            });
            turnPage(searchResults, totalPage);
        });
        $('.city' + i).click(function () {
            let city = $('.city' + i).html();
            let searchResults;
            $.ajax({
                type: 'POST',
                url: 'php/hotCity.php',
                async: false,
                data: {"City": city},
                data_type: 'json',
                success: function (data) {
                    searchResults = JSON.parse(data).results;
                    totalCount = searchResults.length;
                    totalPage = Math.ceil(totalCount / pageSize);
                    $('#picArea').html(showPage(searchResults, 1));
                    $('.pages').html(showPageNumber(totalPage));
                    $('.page1').addClass('active-page');
                }
            });
            turnPage(searchResults, totalPage);
        });
    }

    $('.hot-content-content').click(function () {
        let content = $('.hot-content-content').html();
        let searchResults;
        $.ajax({
            type: 'POST',
            url: 'php/hotContent.php',
            async: false,
            data: {"Content": content},
            data_type: 'json',
            success: function (data) {
                console.log(data.substr(8110, 20));
                searchResults = JSON.parse(data).results;
                totalCount = searchResults.length;
                totalPage = Math.ceil(totalCount / pageSize);
                $('#picArea').html(showPage(searchResults, 1));
                $('.pages').html(showPageNumber(totalPage));
                $('.page1').addClass('active-page');
            }
        });
        turnPage(searchResults, totalPage);
    });

    function showPage(res, currentPage) {
        let totalCount = res.length;
        if (totalCount === 0) {
            return '<h1>没有搜索到任何结果……</h1>';
        }
        let mark = (currentPage - 1) * pageSize;
        let left = totalCount - mark;
        let str = '';
        if (left >= pageSize) {
            for (let i = 0; i < rowPerPage; i++) {
                str += '<div class="rows">';
                for (let j = 0; j < rowSize; j++) {
                    let key = rowPerPage * i + j + mark;
                    str += '<div class="col">\n' +
                        '<a class="col-link" href="">\n' +
                        '<img data-src="holder.js/200x200" class="img-thumbnail" alt="200x200"\n' +
                        'style="width: 200px; height: 200px;" src="img/travel-images/large/' + res[key].PATH + '" data-holder-rendered="true">\n' +
                        '</a>\n' +
                        '</div>';
                }
                str += '</div>';
            }
        } else {
            if (left >= rowSize) {
                let rowLeft = Math.ceil(left / rowSize);
                for (let i = 0; i < rowLeft; i++) {
                    str += '<div class="rows">';
                    let elementLeft = left - rowSize * i;
                    let elementThisRow = (elementLeft >= rowSize) ? rowSize : elementLeft;
                    for (let j = 0; j < elementThisRow; j++) {
                        let key = rowPerPage * i + j + mark;
                        str += '<div class="col">\n' +
                            '<a class="col-link" href="">\n' +
                            '<img data-src="holder.js/200x200" class="img-thumbnail" alt="200x200"\n' +
                            'style="width: 200px; height: 200px;" src="img/travel-images/large/' + res[key].PATH + '" data-holder-rendered="true">\n' +
                            '</a>\n' +
                            '</div>';
                    }
                    str += '</div>';
                }
            } else {
                str += '<div class="rows">';
                for (let i = 0; i < left; i++) {
                    let key = i + mark;
                    str += '<div class="col">\n' +
                        '<a class="col-link" href="">\n' +
                        '<img data-src="holder.js/200x200" class="img-thumbnail" alt="200x200"\n' +
                        'style="width: 200px; height: 200px;" src="img/travel-images/large/' + res[key].PATH + '" data-holder-rendered="true">\n' +
                        '</a>\n' +
                        '</div>';
                }
                str += '</div>';
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
                    $('#picArea').html(showPage(res, i));
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
    
    function fillCountries(countries) {
        let str = '<option value="default">--请选择--</option>';
        for (let i = 0; i < countries.length; i++) {
            str += '<option value="'+i+'">' + countries[i] + '</option>';
        }
        return str;
    }

    function fillContents(contents) {
        let str = '<option value="default">--请选择--</option>';
        for (let i = 0; i < contents.length; i++) {
            str += '<option>' + contents[i] + '</option>';
        }
        return str;
    }

    function fillCity(val, cities) {
        console.log(val);
        if (val === 'default') {
            return '<option value="default">--请选择--</option>';
        }
        else {
            let value = parseInt(val);
            for (let i = 0; i < cities.length; i++) {
                if (value === i) {
                    return fillContents(cities[i]);
                }
            }
        }
    }
});