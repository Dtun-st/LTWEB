import { showToast } from '../script/toast.js';

const form = document.querySelector("form");
const btnLogin = document.getElementById("btn-register");
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirm-password');
var txtEmail=document.getElementById('txtEmail');

form.addEventListener("submit", function (e) {
    e.preventDefault();
    //kiểm tra thông tin hợp lệ
    if (password.value !== confirmPassword.value) {
            e.preventDefault(); // chặn gửi form
            showToast('Nhập lại mật khẩu không đúng!', 'warning');
            confirmPassword.focus();
            return;
        }
    if(txtEmail.value.trim()==''){
        e.preventDefault();
        showToast('Email không được để trống','warning');
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var email=txtEmail.value.trim();
    if (!emailRegex.test(email)) {
        e.preventDefault();
        showToast('Email không đúng định dạng','warning');
        return;
    }



    //truyền thông tin form gồm: username, email,password
    const formData = new FormData(form);

    fetch("../../backend/register.php", {
        method: "POST",
        body: formData
    })

    .then(res => res.json())
    .then(data => {
        if (data.success) {

            showToast(data.message,'success');
            setTimeout(() => {
                    window.location.href = "../../frontend/html/index.html";
            }, 2000);
        } else{
            showToast(data.message,'error');
        }
    })
    .catch(err => {
        alert("Đã xảy ra lỗi khi gửi yêu cầu.");
        console.error(err);
    });
});