<?php 
    $conn= new mysqli('localhost','root','','ban_hang_dien_tu');

    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $user = $result->fetch_assoc()) {
        //kiểm tra password hash (bcrypt)
        if (password_verify($password, $user['password'])) {

            //session lưu phía server, mỗi khi thực hiện 1 thao tác sẽ kiểm tra session để lấy role
            // session_start();
            // $_SESSION['username'] = $user['username'];
            // $_SESSION['email']=$user['email'];
            // $_SESSION['role'] = $user['role'];

            //cookie lưu ở trình duyệt (ko lưu ddc ở server, nó là local storage), để tự động đăng nhập
            //3. kiểm tra tick, lưu vào cookie khi đăng nhập thành công
            //4. khi load form login, kiểm tra cookie và tự động đăng nhập
            echo json_encode(["success" => true, "message" => "Đăng nhập thành công","role"=> $user['role'],"username"=>$user['username'],"email"=>$user['email']],JSON_UNESCAPED_UNICODE);
            exit();

        } else {
            echo json_encode(["success" => false, "message" => "Sai mật khẩu"],JSON_UNESCAPED_UNICODE);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Không tìm thấy tài khoản"],JSON_UNESCAPED_UNICODE);
    }

    $stmt->close();
    $conn->close();
?>