const products = [
  {
    id: 1,
    name: 'iPhone 15 Pro Max',
    description: 'Hàng chính hãng Apple, màu Titan',
    price: 33990000,
    image: 'assets/iphone15.jpg',
    category_id: 1,
    stock: 15
  },
  {
    id: 2,
    name: 'Laptop Dell XPS 13',
    description: 'Mỏng nhẹ, pin lâu, core i7 gen 12',
    price: 25990000,
    image: 'assets/dellxps13.jpg',
    category_id: 2,
    stock: 8
  },
  {
    id: 3,
    name: 'Tai nghe Bluetooth Sony',
    description: 'Chống ồn, pin 30 giờ',
    price: 1990000,
    image: 'assets/sonyheadset.jpg',
    category_id: 3,
    stock: 20
  }
];

// Lấy sản phẩm từ URL
const params = new URLSearchParams(window.location.search);
const productId = parseInt(params.get("id"));
const product = products.find(p => p.id === productId);

if (product) {
  document.getElementById("productImage").src = product.image;
  document.getElementById("productName").textContent = product.name;
  document.getElementById("productDescription").textContent = product.description;
  document.getElementById("productPrice").textContent = product.price.toLocaleString() + "₫";

  // Thêm vào giỏ hàng
  document.querySelector(".add-to-cart").addEventListener("click", () => {
    const quantity = parseInt(document.getElementById("quantity").value);
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const existing = cart.find(item => item.id === product.id);

    if (existing) {
      existing.quantity += quantity;
    } else {
      cart.push({ ...product, quantity });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    alert("Đã thêm vào giỏ hàng!");
  });
} else {
  document.body.innerHTML = "<h2>Sản phẩm không tồn tại!</h2>";
}
