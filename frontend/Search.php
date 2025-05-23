<?php
require 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$category_id = isset($_GET['category']) ? $_GET['category'] : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$where = "WHERE p.name LIKE ?";
$params = ["%$keyword%"];
$types = "s";

if (!empty($category_id)) {
    $where .= " AND p.category_id = ?";
    $params[] = $category_id;
    $types .= "i";
}

$count_sql = "SELECT COUNT(*) FROM products p $where";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param($types, ...$params);
$count_stmt->execute();
$count_stmt->bind_result($total_rows);
$count_stmt->fetch();
$count_stmt->close();

// Lấy sản phẩm
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        $where 
        LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$categories = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm sản phẩm</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f2f2f2; }
        form { margin-bottom: 20px; }
        .pagination a {
            padding: 6px 10px;
            margin: 0 2px;
            border: 1px solid #ccc;
            text-decoration: none;
        }
        .pagination a.active {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }
        .top-bar {
            text-align: right;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="top-bar">
    Xin chào <b><?= $_SESSION['username'] ?></b> | <a href="logout.php">Đăng xuất</a>
</div>

<h2>Tìm kiếm sản phẩm</h2>

<form method="get">
    <input type="text" name="keyword" placeholder="Từ khóa" value="<?= htmlspecialchars($keyword) ?>">
    <select name="category">
        <option value="">-- Tất cả danh mục --</option>
        <?php while ($cat = $categories->fetch_assoc()): ?>
            <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $category_id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endwhile; ?>
    </select>
    <button type="submit">Tìm kiếm</button>
</form>

<?php if ($result->num_rows > 0): ?>
<table>
    <tr>
        <th>Tên</th>
        <th>Mô tả</th>
        <th>Giá</th>
        <th>Danh mục</th>
        <th>Hình ảnh</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td><?= number_format($row['price'], 0, ',', '.') ?> VND</td>
        <td><?= htmlspecialchars($row['category_name']) ?></td>
        <td><img src="<?= htmlspecialchars($row['image']) ?>" width="60"></td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
    <p>Không tìm thấy sản phẩm nào.</p>
<?php endif; ?>

<div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?keyword=<?= urlencode($keyword) ?>&category=<?= $category_id ?>&page=<?= $i ?>"
           class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>

</body>
</html>
