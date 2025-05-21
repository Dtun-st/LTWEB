// Xử lý form thanh toán
document.getElementById("paymentForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Ngăn hành vi mặc định gửi form

    const fullName = document.getElementById("fullName").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const address = document.getElementById("address").value;

    // Thông báo thông tin đặt hàng
    alert(`Đặt hàng thành công!\nTên: ${fullName}\nEmail: ${email}\nSố điện thoại: ${phone}\nĐịa chỉ: ${address}`);

    // Tùy chọn: gửi dữ liệu về server qua fetch/ajax nếu cần
});
