<?php 
  include '../../backend/check-session.php';

  $products = [
    [
      'id' => 1,
      'name' => 'iPhone 15 Pro Max',
      'description' => 'Hàng chính hãng Apple, màu Titan',
      'price' => 33990000,
      'image' => '../resources/images/iphone15.jpg',
      'category_id' => 1,
      'stock' => 15
    ],
    [
      'id' => 2,
      'name' => 'Laptop Dell XPS 13',
      'description' => 'Mỏng nhẹ, pin lâu, core i7 gen 12',
      'price' => 25990000,
      'image' => '../resources/images/dellxps13.jpg',
      'category_id' => 2,
      'stock' => 8
    ],
    [
      'id' => 3,
      'name' => 'Tai nghe Bluetooth Sony',
      'description' => 'Chống ồn, pin 30 giờ',
      'price' => 1990000,
      'image' => '../resources/images/sonyheadset.jpg',
      'category_id' => 3,
      'stock' => 20
    ]
  ];

  // ID sp
  $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
  $product = null;
  foreach ($products as $p) {
    if ($p['id'] === $productId) {
      $product = $p;
      break;
    }
  }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết sản phẩm</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/product-detail.css">
</head>
<body>

<?php if ($product): ?>
  <div class="product-detail">
    <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p><?= number_format($product['price']) ?>₫</p>

    <label for="quantity">Số lượng:</label>
    <input type="number" id="quantity" name="quantity" min="1" max="<?= $product['stock'] ?>" value="1">

    <button class="add-to-cart">Thêm vào giỏ hàng</button>
  </div>

  <script>
    document.querySelector(".add-to-cart").addEventListener("click", () => {
      const quantity = parseInt(document.getElementById("quantity").value);
      const product = <?= json_encode($product) ?>;

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
  </script>
<?php else: ?>
  <h2 style="text-align: center; margin-top: 50px;">Sản phẩm không tồn tại!</h2>
<?php endif; ?>

</body>
</html>
