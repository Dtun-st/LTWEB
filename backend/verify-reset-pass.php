<?php
    $conn= new mysqli('localhost','root','','ban_hang_dien_tu');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $code = $_POST['code'];
        $newPassword = $_POST['new_password'];

        $stmt = $conn->prepare("SELECT * FROM authentication WHERE email = ? AND code = ?");
        $stmt->bind_param("ss",$email, $code);
        $stmt->execute();

        $result=$stmt->get_result();
        $auth=$result->fetch_assoc();
        if ($auth) {
            if (strtotime($auth['expires_at']) > time()) {
                // Cập nhật mật khẩu mới
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
                $stmt->bind_param("ss",$hashedPassword, $email);
                $stmt->execute();

                // Xóa mã
                $stmt = $conn->prepare("DELETE FROM authentication WHERE email = ?");
                $stmt->bind_param("s",$email);
                $stmt->execute();

                echo json_encode(["success"=>true, 'message' => 'Đổi mật khẩu thành công'],JSON_UNESCAPED_UNICODE);
            } 
            else {
                echo json_encode(["success"=>false, 'message' => 'Mã đã hết hạn'],JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode(["success"=>false, 'message' => 'Mã không hợp lệ'],JSON_UNESCAPED_UNICODE);
        }
    }
?>
