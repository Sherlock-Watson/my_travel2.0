$(document).ready(function() {
    let errorArea = $('#errorMessageArea');
    let errorArea1 = $('#errorMessageArea1');
    let errorArea2 = $('#errorMessageArea2');
    let title = $('#title');
    let description = $('#description');
    let country = $('#country');
    let city = $('#city');
    let content = $('#content');
    let fileChanged;
    errorArea.attr('style', 'visibility:hidden');
    errorArea1.attr('style', 'visibility:hidden');
    errorArea2.attr('style', 'visibility:hidden');

        $.ajax({
            type: 'POST',
            url: 'php/myAccount.php',
            async: false,
            success: function (data) {
                $('.myAccount').html(data);
            }
        });

        title.change(function () {
            validTitle();
        });

        description.change(function () {
            validDescription();
        });



        let filter;

        $.ajax({
            type: 'POST',
            url: 'php/uploadFilter.php',
            async: false,
            success: function (data) {
                filter = JSON.parse(data);
                country.html(fillContents(filter.Country));
            }
        });



        country.change(function () {
            if (country.val() === 'default') {
                city.html('<option value="default">--请选择--</option>');
            } else {
                let cities;
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: 'php/findCity.php',
                    data: {"country": country.val()},
                    data_type: 'json',
                    success: function (data) {
                        //console.log(data);
                        cities = JSON.parse(data).city;
                    }
                });
                if (cities) {
                    city.html(fillContents(cities));
                }
            }
        });



        $("#file0").change(function () {
            let objUrl = getObjectURL(this.files[0]);//获取文件信息
            console.log("objUrl = " + objUrl);
            if (objUrl) {
                $("#img0").attr("src", objUrl);
            }
            fileChanged = true;
        });

    if (getQueryVariable('ImageID') === false) {

        $('#btnUpload').click(function () {
            let form = new FormData(document.getElementById('upload'));
            if (validTitle() && validDescription() && validFilter() && changedFile()) {
                $.ajax({
                    type: 'POST',
                    url: 'php/upload.php',
                    data: form,
                    processData: false,
                    contentType: false,
                    async: false,
                    success: function (data) {
                        if (data === 'file existed') {
                            alert('文件已经存在了或者你压根没上传！');
                        } else if (/^[0-9]+$/.test(data)) {
                            window.location.href = 'detail.html?ImageID=' + data;
                        } else {
                            errorArea2.empty().attr('style', 'visibility:visible').html('上传失败！');
                        }
                    }
                });
            }
        });
    }
    else {
        $('#btnUpload').val('修改');
        let imageID = getQueryVariable('ImageID');
        console.log(imageID);
        let result;
        $.ajax({
           type: 'POST',
           url: 'php/modifyImage.php',
           data: {"ImageID": imageID},
           data_type: 'json',
           async: false,
           success: function (data) {
               result = JSON.parse(data);
           }
        });
        title.val(result.Title);
        description.val(result.Description);
        //country.find("option[value='"+result.Country+"']").attr("selected",true);
        country.val(result.Country);
        country.change();
        city.val(result.City);
        content.val(result.Content);
        $('#img0').attr("src", "img/travel-images/large/" + result.PATH);
        $('#imageID').val(imageID);
        $('#btnUpload').click(function () {
            let form = new FormData(document.getElementById('upload'));
            if (validTitle() && validDescription() && validFilter() && changedFile()) {
                $.ajax({
                    type: 'POST',
                    url: 'php/modify.php',
                    data: form,
                    processData: false,
                    contentType: false,
                    async: false,
                    success: function (data) {
                        if (data) {
                            window.location.href = 'detail.html?ImageID=' + data;
                        }
                        else {
                            errorArea2.empty().attr('style', 'visibility:visible').html('上传失败！');
                        }
                    }
                });
            }
        });
    }

    function getObjectURL(file) {
        let url = null;
        if (window.createObjectURL!=undefined) {
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }

    function changedFile() {
        if(fileChanged) {
            errorArea2.empty().attr('style', 'visibility:hidden');
            return true;
        }
        else {
            errorArea2.attr('style', 'visibility:visible').html('请输入标题！');
            return false;
        }
    }
    
    function validTitle() {
        if (title.val() === null) {
            errorArea.attr('style', 'visibility:visible').html('请输入标题！');
            return false;
        }
        else {
            errorArea.empty().attr('style', 'visibility:hidden');
            return true;
        }
    }

    function validDescription() {
        if (description.val() === null) {
            errorArea1.attr('style', 'visibility:visible').html('请输入图片描述！');
            return false;
        }
        else {
            errorArea1.empty().attr('style', 'visibility:hidden');
            return true;
        }
    }

    function validFilter() {
        if (city.val() !== 'default' && content.val() !== 'default') {
            errorArea2.empty().attr('style', 'visibility:hidden');
            return true;
        }
        else {
            errorArea2.attr('style', 'visibility:visible').html('请进行筛选！');
            return false;
        }
    }

    function fillContents(contents) {
        let str = '<option value="default">--请选择--</option>';
        for (let i = 0; i < contents.length; i++) {
            str += '<option>' + contents[i] + '</option>';
        }
        return str;
    }

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