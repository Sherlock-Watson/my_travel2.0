/*
let repass = document.getElementById("rePassword");
let pword = document.getElementById("password");
let errorMessageArea = document.getElementById("errorMessageArea");
if (repass !== null) {
    errorMessageArea.style.visibility = "hidden";
    repass.onchange = function () {
        if (repass.value !== pword.value) {
            errorMessageArea.style.visibility = "visible";
            errorMessageArea.innerHTML = "两次输入的密码不一致";
        }
        else {
            errorMessageArea.innerHTML = "";
            errorMessageArea.style.visibility = "hidden";
        }
    }
    pword.onchange = function () {
        if (repass.value !== pword.value) {
            errorMessageArea.style.visibility = "visible";
            errorMessageArea.innerHTML = "两次输入的密码不一致";
        }
        else {
            errorMessageArea.innerHTML = "";
            errorMessageArea.style.visibility = "hidden";
        }
    }
}*/
$(document).ready(function() {
    let rePass = $('#rePassword');
    let pass = $('#password');
    let name = $('#userName');
    let email = $('#email');
    let errorArea = $('#errorMessageArea');
    let errorArea1 = $('#errorMessageArea1');
    let errorArea2 = $('#errorMessageArea2');
    let errorArea3 = $('#errorMessageArea3');
    let errorArea4 = $('#errorMessageArea4');
    errorArea.attr('style', 'visibility:hidden');
    errorArea1.attr('style', 'visibility:hidden');
    errorArea2.attr('style', 'visibility:hidden');
    errorArea3.attr('style', 'visibility:hidden');
    errorArea4.attr('style', 'visibility:hidden');
    pass.change(function () {
        goodPass(pass.val());
    });
    rePass.change(function () {
        validPass();
    });
    name.change(function () {
        validUsername(name.val());
    });
    email.change(function () {
        validEmail(email.val());
    })
    $('#register').click(function () {
        if(validPass() && goodPass(pass.val()) && validUsername(name.val()) && validEmail(email.val())) {
            $.ajax({
                type: 'POST',
                url: 'php/registerProcess.php',
                async: false,
                data: {"userName":name.val(),"email":email.val(),"password":pass.val(), "rePassword":rePass.val()},
                data_type: 'json',
                success: function (data) {
                    console.log(data);
                    let result = JSON.parse(data);
                    if (!result.validUserName) {
                        errorArea2.attr('style', 'visibility:visible').html('这个用户名已经被注册过了，换一个吧！');
                    }
                    if (!result.validRegister) {
                        errorArea3.attr('style', 'visibility:visible').html('注册失败！');
                    }
                    if (result.validUserName && result.validRegister) {
                        window.location.href = 'logIn.html';
                    }
                }
            });
        }
    });

    function validPass() {
        if (rePass.val() !== null) {
            if (pass.val() !== rePass.val()) {
                errorArea.attr('style', 'visibility:visible').html('两次输入的密码不一致');
                return false;
            } else {
                errorArea.empty().attr('style', 'visibility:hidden');
                return true;
            }
        }
        else {
            errorArea.attr('style', 'visibility:visible').html('请再输入一次密码！');
            return false;
        }
    }

    function goodPass(pass) {
        if (pass !== null) {
            let pat1 = /^[0-9]+$/;
            let pat2 = /^[a-z]+$/;
            let pat3 = /^[A-Z]+$/;
            if (pat1.test(pass) || pat2.test(pass) || pat3.test(pass)) {
                errorArea1.attr('style', 'visibility:visible').html('密码不能只包含数字/小写字母/大写字母！');
                return false;
            } else {
                errorArea1.empty().attr('style', 'visibility:hidden');
                return true;
            }
        }
        else {
            errorArea1.attr('style', 'visibility:visible').html('请填写密码！');
        }
    }
    function validUsername(name) {
        if (name !== null) {
            let pat = /^[a-z0-9]+$/i;
            if (pat.test(name)) {
                errorArea2.empty().attr('style', 'visibility:hidden');
                return true;
            } else {
                errorArea2.attr('style', 'visibility:visible').html('用户名不能包含字母、数字以外的字符！');
                return false;
            }
        }
        else {
            errorArea2.attr('style', 'visibility:visible').html('用户名不能空着！');
        }
    }

    function validEmail(email) {
        if (email !== null) {
            let pat = /^([A-Za-z0-9_\-.\u4e00-\u9fa5])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,8})$/;
            if (pat.test(email)) {
                errorArea4.empty().attr('style', 'visibility:hidden');
                return true;
            } else {
                errorArea4.attr('style', 'visibility:visible').html('邮箱格式不正确！');
                return false;
            }
        }
        else {
            errorArea4.attr('style', 'visibility:visible').html('请填写邮箱！');
            return false;
        }
    }
});