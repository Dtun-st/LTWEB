import { showToast } from "../script/toast.js";

const form = document.querySelector("form");
const btnLogin = document.getElementById("btn-login");

//lưu cookie
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days*24*60*60*1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = `${name}=${encodeURIComponent(value)};${expires};path=/`;
}

function deleteCookie(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/;';
}


form.addEventListener("submit", function (e) {
    e.preventDefault();

    //truyền thông tin form gồm: username, password,...
    const formData = new FormData(form);

    fetch("../../backend/login.php", {
        method: "POST",
        body: formData
    })

    .then(res => res.json())
    .then(data => {
        if (data.success) {
            //KIỂM TRA CHECKBOX TỰ ĐỘNG ĐĂNG NHẬP
            const autoLogin = document.getElementById("auto-login").checked;
            if (autoLogin) {
                setCookie("username", formData.get("username"), 7);//7 là số ngày lưu lại trên cookie
                setCookie("role", data.role, 7);
                setCookie("email",data.email,7);
            } else {
                // Xóa cookie nếu không chọn
                deleteCookie("username");
                deleteCookie("role");
                deleteCookie("email");
            }


            showToast(data.message,'success');
            setTimeout(() => {
                
                if(data.role=="user"){
                    window.location.href = "../../frontend/html/index.html";
                }else if(data.role=="admin"){
                    window.location.href = "../../frontend/html/forgot-password.html";
                }

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