<?php
$servername = "localhost";  // WAMP thường dùng localhost
$username = "root";         // Mặc định user của WAMP là root
$password = "";             // Mặc định password để trống trên WAMP
$dbname = "ban_hang_dien_tu"; // Thay bằng tên database bạn tạo

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Đặt charset để tránh lỗi font tiếng Việt
$conn->set_charset("utf8");
