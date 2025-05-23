<?php
include(__DIR__ . '/../../backend/db.php');

// Lấy danh sách sản phẩm và danh mục
$products = $conn->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id");
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <h1>Quản lý sản phẩm</h1>

    <h2>Thêm sản phẩm mới</h2>
    <form method="POST" action="../../backend/admin.php" enctype="multipart/form-data">
        <input name="name" placeholder="Tên sản phẩm" required>
        <textarea name="description" placeholder="Mô tả" required></textarea>
        <input type="number" name="price" placeholder="Giá" min="0" required>
        <input type="file" name="image" accept="image/*" required>
        <select name="category_id" required>
            <option value="">-- Chọn danh mục --</option>
            <?php while ($cat = $categories->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endwhile; ?>
        </select>
        <input type="number" name="stock" placeholder="Số lượng" min="0" value="0">
        <button type="submit">Thêm sản phẩm</button>
    </form>

    <h2>Danh sách sản phẩm</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Ảnh</th>
            <th>Danh mục</th>
            <th>Số lượng</th>
            <th>Xóa</th>
            <th>Sửa</th>
        </tr>
        <?php $i = 1;
        while ($sp = $products->fetch_assoc()): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($sp['name']) ?></td>
                <td><?= nl2br(htmlspecialchars($sp['description'])) ?></td>
                <td><?= number_format($sp['price'], 0, ',', '.') ?> đ</td>
                <td>
                    <?php if (!empty($sp['image']) && file_exists('../../images/' . $sp['image'])): ?>
                        <img src="../../images/<?= htmlspecialchars($sp['image']) ?>" height="60" alt="Ảnh sản phẩm"><br>
                        <a href="../../images/<?= htmlspecialchars($sp['image']) ?>" target="_blank">
                            <?= htmlspecialchars($sp['image']) ?>
                        </a>
                    <?php else: ?>
                        <span>Chưa có ảnh</span>
                    <?php endif; ?>
                </td>

                <td><?= htmlspecialchars($sp['category_name']) ?></td>
                <td><?= (int)$sp['stock'] ?></td>
                <td>
                    <form method="POST" action="../../backend/admin.php" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                        <input type="hidden" name="delete_id" value="<?= $sp['id'] ?>">
                        <button type="submit" style="cursor:pointer;">❌</button>
                    </form>
                </td>
                <td>
                    <a href="edit.php?id=<?= $sp['id'] ?>" style="text-decoration:none; font-size:20px;" title="Sửa sản phẩm">✏️</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>