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

// Lọc sản phẩm
function filterProducts() {
  const categoryFilter = document.getElementById('categoryFilter').value;
  const searchInput = document.getElementById('searchInput').value.toLowerCase();
  const filteredProducts = products.filter(product => {
    const matchesCategory = categoryFilter ? product.category_id == categoryFilter : true;
    const matchesSearch = product.name.toLowerCase().includes(searchInput);
    return matchesCategory && matchesSearch;
  });

  displayProducts(filteredProducts);
}

// Hàm hiển thị sản phẩm
function displayProducts(products) {
  const productGrid = document.getElementById('productGrid');
  productGrid.innerHTML = '';
  products.forEach(product => {
    const productCard = document.createElement('div');
    productCard.classList.add('product-card');
    productCard.innerHTML = `
      <a href="product-detail.html?id=${product.id}">
        <img src="${product.image}" alt="${product.name}">
        <h3>${product.name}</h3>
        <p>${product.description}</p>
        <p><strong>Giá:</strong> ${product.price.toLocaleString()}₫</p>
      </a>
    `;
    productGrid.appendChild(productCard);
  });
}

// Hiển thị tất cả sản phẩm khi tải trang
displayProducts(products);
