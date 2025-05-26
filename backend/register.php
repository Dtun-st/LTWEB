<?php 
    $conn = new mysqli('localhost', 'root', '', 'ban_hang_dien_tu');

    if ($conn->connect_error) {
        die(json_encode(["success" => false, "message" => "Kết nối thất bại: " . $conn->connect_error], JSON_UNESCAPED_UNICODE));
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Username hoặc email đã tồn tại"], JSON_UNESCAPED_UNICODE);
    } else {
        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Thêm người dùng mới
        
        // session_start();
        // $_SESSION['username'] = $user['username'];
        // $_SESSION['email']=$user['email'];
        // $_SESSION['role'] = $user['role'];

        $insertStmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')");
        $insertStmt->bind_param("sss", $username, $hashedPassword, $email);

        if ($insertStmt->execute()) {
            echo json_encode(["success" => true, "message" => "Đăng ký thành công"], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(["success" => false, "message" => "Lỗi khi thêm người dùng: " . $conn->error], JSON_UNESCAPED_UNICODE);
        }

        $insertStmt->close();
    }

    $stmt->close();
    $conn->close();
?>
