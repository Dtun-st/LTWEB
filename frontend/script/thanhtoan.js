document.getElementById("paymentForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const name = document.getElementById("fullName").value.trim();
  const email = document.getElementById("email").value.trim();
  const phone = document.getElementById("phone").value.trim();
  const address = document.getElementById("address").value.trim();

  if (!name || !email || !phone || !address) {
    alert("Vui lòng nhập đầy đủ thông tin!");
    return;
  }

  if (!/^\d{10,11}$/.test(phone)) {
    alert("Số điện thoại không hợp lệ!");
    return;
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    alert("Email không hợp lệ!");
    return;
  }

  alert(`✅ Thanh toán thành công!\nTên: ${name}\nEmail: ${email}\nSĐT: ${phone}\nĐịa chỉ: ${address}`);
});
