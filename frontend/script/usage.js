import { showToast } from './toast.js';
import { showConfirmPopup } from './confirmPopup.js';

function showLoginToast() {
    showToast('Vui lòng nhập đầy đủ thông tin', 'error');
}

function showSuccessToast() {
    showToast('Đăng xuất thành công', 'success');
}

let button=document.getElementById('btn');
button.addEventListener('click',()=>{
    showLoginToast();
})

let popup=document.querySelector('.btn-popup');
popup.addEventListener('click',()=>{
    showConfirmPopup(
                'Xác nhận',  // Tiêu đề
                'Bạn có chắc chắn muốn đăng xuất không?',  // Nội dung
                () => {
                    showSuccessToast()
                }
            );
})