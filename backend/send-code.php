<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    // luồng hoạt động
    //  1. khi nhấn nút gửi mã, phía js fetch forgot-password.php để xóa mã cũ,tạo mã mới (lưu trong database), rồi gửi mã qua email
    //  2. khi nhấn nút xác nhận, fetch verify.php, xác thực mã hợp lệ (đúng, còn thời gian) ,cập nhật lại mk, xóa mã khỏi database và gửi response 
    //  3. nếu mã hết hạn, thông báo lỗi
    $conn= new mysqli('localhost','root','','ban_hang_dien_tu');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];

        //kiểm tra email đã đăng ký tài khoản hay chưa
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            echo json_encode(["success" => false, "message" => "Email chưa được đăng ký!"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Tạo mã xác nhận ngẫu nhiên
        $code = rand(100000, 999999);
        $expires_at = date("Y-m-d H:i:s", time() + 120); // Hết hạn sau 2 phút

        // Xóa mã cũ nếu có
        $stmt = $conn->prepare("DELETE FROM authentication WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute();

        // Lưu mã mới
        $stmt = $conn->prepare("INSERT INTO authentication (email, code, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss",$email, $code, $expires_at);
        $stmt->execute();

        //gửi email xác nhận
        require 'PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            //Server settings: Người gửi
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //gmail smtp host
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'quynhoppa2112@gmail.com';                                 //SMTP username
            $mail->Password   = 'qrxr ixip bvnx sbxa';                               //gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Người gửi/nhận
            $mail->setFrom('quynhoppa2112@gmail.com', 'HC Electronics');
            $mail->addAddress($email, 'Khách hàng');

            $mail->isHTML(true);                               
            $mail->Subject = mb_encode_mimeheader('Xác nhận thay đổi mật khẩu', 'UTF-8');
            $mail->Body    = "Mã xác nhận của bạn là: <b>$code</b>";

            $mail->send();
            echo json_encode(["success"=>true, 'message'=>'Đã gửi mã xác thực!'], JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(["success"=>false, 'message'=>$mail->ErrorInfo], JSON_UNESCAPED_UNICODE);
        }
    }
?>

