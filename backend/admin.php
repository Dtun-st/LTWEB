<?php
include 'db.php';

function redirect_back() {
    header("Location: ../frontend/html/admin.php");
    exit;
}

// Xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    // Xóa ảnh cũ (nếu có)
    $result = $conn->query("SELECT image FROM products WHERE id=$id");
    if ($result && $row = $result->fetch_assoc()) {
        $oldImage = $row['image'];
        if ($oldImage && file_exists('../images/' . $oldImage)) {
            unlink('../images/' . $oldImage);
        }
    }
    // Xóa sản phẩm
    $conn->query("DELETE FROM products WHERE id=$id");
    redirect_back();
}

// Thêm sản phẩm mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['description'], $_POST['price'], $_POST['category_id'])) {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $description = $conn->real_escape_string(trim($_POST['description']));
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;

    // Xử lý ảnh upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExt, $allowed)) {
            die('Chỉ cho phép upload file ảnh JPG, PNG, GIF');
        }
        // Tạo tên file mới tránh trùng
        $newFileName = uniqid('img_') . '.' . $fileExt;
        $destPath = '../images/' . $newFileName;
        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            die('Lỗi khi lưu file ảnh');
        }
    } else {
        die('Bạn phải chọn ảnh sản phẩm');
    }

    // Thêm vào database
    $sql = "INSERT INTO products (name, description, price, image, category_id, stock) VALUES 
            ('$name', '$description', $price, '$newFileName', $category_id, $stock)";
    if ($conn->query($sql)) {
        redirect_back();
    } else {
        die('Lỗi khi thêm sản phẩm: ' . $conn->error);
    }
}
// Chỉnh sửa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = intval($_POST['edit_id']);
    $name = $conn->real_escape_string(trim($_POST['name']));
    $description = $conn->real_escape_string(trim($_POST['description']));
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;

    $updateImage = "";

    // Nếu có upload ảnh mới
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExt, $allowed)) {
            die('Chỉ cho phép upload ảnh JPG, PNG, GIF');
        }

        $newFileName = uniqid('img_') . '.' . $fileExt;
        $destPath = '../images/' . $newFileName;
        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            die('Lỗi khi lưu ảnh mới');
        }

        // Xóa ảnh cũ
        $res = $conn->query("SELECT image FROM products WHERE id=$id");
        if ($res && $row = $res->fetch_assoc()) {
            $oldImage = $row['image'];
            if ($oldImage && file_exists('../images/' . $oldImage)) {
                unlink('../images/' . $oldImage);
            }
        }

        $updateImage = ", image='$newFileName'";
    }

    $sql = "UPDATE products SET 
            name='$name', description='$description', price=$price, 
            category_id=$category_id, stock=$stock $updateImage
            WHERE id=$id";

    if ($conn->query($sql)) {
        redirect_back();
    } else {
        die("Lỗi cập nhật: " . $conn->error);
    }
}

// Nếu vào thẳng file không qua POST, quay về trang quản lý
redirect_back();
