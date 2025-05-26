<?php
    //kiểm tra cookie tự động đăng nhập
    session_start();

    if (isset($_COOKIE['username']) && isset($_COOKIE['role']) && isset($_COOKIE['email'])) {
        $username = $_COOKIE['username'];
        $role = $_COOKIE['role'];
        $email = $_COOKIE['email'];

        $conn = new mysqli('localhost', 'root', '', 'ban_hang_dien_tu');
        if ($conn->connect_error) {
            die("Kết nối DB thất bại: " . $conn->connect_error);
        }

        // Kiểm tra thông tin cookie với DB
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND email = ? AND role = ?");
        $stmt->bind_param("sss", $username, $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $user = $result->fetch_assoc()) {
            // Tạo session để đánh dấu đã đăng nhập
            // $_SESSION['username'] = $user['username'];
            // $_SESSION['role'] = $user['role'];
            // $_SESSION['email'] = $user['email'];

            // Redirect đến trang tương ứng theo role
            if ($user['role'] === 'admin') {
                header("Location: ../../frontend/html/forgot-password.html");
            } else {
                header("Location: ../../frontend/html/index.html");
            }
            exit;
        }
        $stmt->close();
        $conn->close();
    }

// Nếu không có cookie hoặc xác thực không thành công thì hiển thị form login
?>

<!-- HTML form login ở đây -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/toast.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
</head>
<body>
    <div class="blob"></div>
    <div class="wrapper">
        <form method="POST" action="../../backend/login.php">
            <h2>Đăng nhập</h2>
            <div class="input-box">
                <span class="icon">
                    <ion-icon name="person"></ion-icon>
                </span>
                <input type="text" required name="username" title="Tài khoản/Email" />
                <label>Tài khoản/Email</label>
            </div>
            <div class="input-box">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" required name="password" title="Mật khẩu">
                <label>Mật khẩu</label>
            </div>
            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="auto-login" id="auto-login">Tự động đăng nhập
                </label>
                <a href="../html/forgot-password.html">Quên mật khẩu</a>
            </div>
            <button type="submit" id="btn-login">Đăng nhập</button>

            <div class="register-link">
                <p>Chưa có tài khoản? <a href="register.html">Đăng ký</a></p>
            </div>
        </form>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script type="module" src="../script/login.js"></script>
</body>

</html>