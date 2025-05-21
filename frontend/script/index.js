const bannerImages = [
  "../images/banner1.jpg",
  "../images/banner2.jpg"
];

let current = 0;
const bannerDiv = document.getElementById("banner-slide");

function showSlide(i) {
  current = (i + bannerImages.length) % bannerImages.length;
  bannerDiv.style.backgroundImage = `url(${bannerImages[current]})`;
}

function nextSlide() {
  showSlide(current + 1);
}

function prevSlide() {
  showSlide(current - 1);
}

// Gọi lần đầu
showSlide(0);

// Tự động chuyển ảnh sau 4 giây
setInterval(() => {
  nextSlide();
}, 4000);
// Hiển thị tất cả sản phẩm khi tải trang
displayProducts(products);
