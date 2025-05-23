document.getElementById("productForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const name = document.getElementById("productName").value.trim();
  const price = document.getElementById("price").value.trim();
  const imageUrl = document.getElementById("imageUrl").value.trim();
  const description = document.getElementById("description").value.trim();

  if (!name || !price) {
    alert("Vui lòng nhập tên và giá sản phẩm!");
    return;
  }

  const preview = document.getElementById("productPreview");
  preview.innerHTML = `
    <h3>Sản phẩm vừa thêm:</h3>
    <p><strong>Tên:</strong> ${name}</p>
    <p><strong>Giá:</strong> ${Number(price).toLocaleString()} VNĐ</p>
    ${imageUrl ? `<img src="${imageUrl}" style="max-width:100%; height:auto;">` : ""}
    <p><strong>Mô tả:</strong> ${description}</p>
  `;
});
