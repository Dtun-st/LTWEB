import { showToast } from '../script/toast.js';

var form=document.querySelector('form');
var btnSendCode = document.getElementById('btn-send-code');
var btnConfirm=document.getElementById('btn-confirm');
var txtEmail= document.getElementById('txtEmail');
var txtCode=document.getElementById('txtCode');
var txtNewPassword=document.getElementById('txtNewPassword');

btnSendCode.addEventListener('click', function (e) {
  e.preventDefault(); 
  //kiểm tra hợp lệ
  if(txtEmail.value.trim()==''){
    showToast('Email không được để trống','warning');
    return;
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  var email=txtEmail.value.trim();
  if (!emailRegex.test(email)) {
    showToast('Email không đúng định dạng','warning');
    txtEmail.focus();
    return;
  }
  //nút gửi mã đếm ngược 2p 
  let countdown = 120; 
  btnSendCode.disabled = true;
  btnSendCode.classList.add('cooldown'); 

  const originalText = 'Gửi mã';

  const formatTime = (seconds) => {
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
  };

  btnSendCode.textContent = `${originalText} (${formatTime(countdown)})`;

  const interval = setInterval(() => {
    countdown--;
    if (countdown > 0) {
      btnSendCode.textContent = `${originalText} (${formatTime(countdown)})`;
    } else {
      clearInterval(interval);
      btnSendCode.disabled = false;
      btnSendCode.classList.remove('cooldown'); // bỏ class khi xong
      btnSendCode.textContent = originalText;
    }
  }, 1000);

  //fetch send-code.php để gửi mã qua email
  var formData=new FormData(form);
  fetch("../../backend/send-code.php", {
        method: "POST",
        body: formData
  })
  
  .then(res => res.json())
  .then(data => {
      if (data.success) {
        showToast(data.message,'success');
      } else{
          showToast(data.message,'error');
      }
  })
  .catch(err => {
      showToast('Đã xảy ra lỗi khi gửi yêu cầu','error');
      console.error(err);
  });
});

//xử lý nút confirm
btnConfirm.addEventListener('click', function (e) {
  e.preventDefault(); 
  //kiểm tra hợp lệ
  if(txtEmail.value.trim()==''){
    showToast('Email không được để trống','warning');
    return;
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  var email=txtEmail.value.trim();
  if (!emailRegex.test(email)) {
    showToast('Email không đúng định dạng','warning');
    txtEmail.focus();
    return;
  }

  if(txtCode.value.trim()=='' || txtNewPassword.value.trim()==''){
    showToast('Vui lòng nhập đầy đủ thông tin','warning');
    return;
  }
  //fetch verify-pass.php để kiểm tra mã và thực hiện đổi mật khẩu
  var formData=new FormData(form);
  fetch("../../backend/verify-reset-pass.php", {
      method: "POST",
      body: formData
  })

  .then(res => res.json())
  .then(data => {
      if (data.success) {
          showToast(data.message,'success');
      } else{
          showToast(data.message,'error');
      }
  })
  .catch(err => {
      showToast("Đã xảy ra lỗi khi gửi yêu cầu.",'error');
      console.error(err);
  });
});

