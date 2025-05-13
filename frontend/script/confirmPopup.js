export function showConfirmPopup(title = 'Xác nhận', message = 'Bạn có chắc không?', onConfirm = () => {}) {
    // Nếu popup đã tồn tại thì xóa trước
    const existingPopup = document.getElementById('confirmPopup');
    if (existingPopup) existingPopup.remove();

    // Tạo HTML popup
    const popup = document.createElement('div');
    popup.id = 'confirmPopup';
    popup.innerHTML = `
        <div class="popup-overlay">
            <div class="popup-box">
                <h3 class="popup-title">${title}</h3>
                <p class="popup-message">${message}</p>
                <div class="popup-buttons">
                    <button id="popupConfirm">Xác nhận</button>
                    <button id="popupCancel">Hủy</button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(popup);

    // Gắn sự kiện
    document.getElementById('popupConfirm').addEventListener('click', () => {
        onConfirm();
        popup.remove();
    });

    document.getElementById('popupCancel').addEventListener('click', () => {
        popup.remove();
    });
}
