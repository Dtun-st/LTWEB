<?php
include(__DIR__ . '/../../backend/db.php');

// Kiểm tra nếu có ID sản phẩm cần sửa
if (!isset($_GET['id'])) {
    die("Thiếu ID sản phẩm");
}

$id = intval($_GET['id']);

// Lấy thông tin sản phẩm cần sửa
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
if (!$product) {
    die("Không tìm thấy sản phẩm");
}

// Lấy danh sách danh mục
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="../css/edit.css">
</head>
<body>
    <div class="container">
        <h2>🛠️ Sửa sản phẩm</h2>
        <form method="POST" action="../../backend/admin.php" enctype="multipart/form-data">
            <input type="hidden" name="edit_id" value="<?= $product['id'] ?>">

            <label>Tên sản phẩm:</label>
            <input name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label>Mô tả:</label>
            <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

            <label>Giá:</label>
            <input type="number" name="price" value="<?= $product['price'] ?>" min="0" required>

            <label>Ảnh hiện tại:</label><br>
            <?php if (!empty($product['image']) && file_exists(__DIR__ . '/../../images/' . $product['image'])): ?>
                <img src="../../images/<?= htmlspecialchars($product['image']) ?>" height="100" alt="Ảnh sản phẩm">
            <?php else: ?>
                <span>Chưa có ảnh</span>
            <?php endif; ?>

            <label>Thay đổi ảnh (nếu muốn):</label>
            <input type="file" name="image" accept="image/*">

            <label>Danh mục:</label>
            <select name="category_id" required>
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Số lượng:</label>
            <input type="number" name="stock" value="<?= $product['stock'] ?>" min="0" required>

            <button type="submit">Cập nhật</button>
            <a href="admin.php" class="btn-back">Quay lại</a>
        </form>
    </div>
</body>
</html>
