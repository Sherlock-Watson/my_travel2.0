$(document).ready(function() {
    $('#errorMessageArea').attr('style','visibility:hidden');
    $('#logIn').click(function () {
        let username = $('#userName').val();
        let password = $('#password').val();
        if (username && password) {
            $.ajax({
                type: 'POST',
                url: 'php/logInProcess.php',
                async: false,
                data: {"userName": username, "password": password},
                success: function (data) {
                    if (data) {
                        window.location.href = 'index.html?logIn=' + data;
                    } else {
                        $('#errorMessageArea').attr('style', 'visibility:visible').html('用户名/邮箱或密码错误');
                    }
                }
            });
        }
        else {
            $('#errorMessageArea').attr('style', 'visibility:visible').html('请填写完整');
        }
    })
});