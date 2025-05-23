<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <div class="blob"></div>
    <div class="wrapper">
        <form method="POST" action="register.php">
            <h2>Đăng ký</h2>
            <div class="input-box">
                <span class="icon">
                    <ion-icon name="person"></ion-icon>
                </span>
                <input type="text" required placeholder="Tên tài khoản" title="Tên tài khoản">
                <label>Tên tài khoản</label>
            </div>

            <div class="input-box">
                <span class="icon">
                    <ion-icon name="person"></ion-icon>
                </span>
                <input type="text" required placeholder="Email" title="Email">
                <label>Email</label>
            </div>

            <div class="input-box">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" required placeholder="Mật khẩu" title="Mật khẩu">
                <label>Mật khẩu</label>
            </div>

            <div class="input-box">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" required placeholder="Xác nhận mật khẩu" title="Xác nhận mật khẩu">
                <label>Xác nhận mật khẩu</label>
            </div>

            <!-- <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="" id="">Tự động đăng nhập
                </label>
                <a href="#">Quên mật khẩu</a>
            </div> -->

            <button type="submit">Đăng Ký</button>

            <div class="register-link">
                <p>Đã có tài khoản? <a href="login.html">Đăng nhập</a></p>
            </div>
        </form>
    </div>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>