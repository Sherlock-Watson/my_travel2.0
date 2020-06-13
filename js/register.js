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
}