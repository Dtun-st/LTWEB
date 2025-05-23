<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Form Thanh Toán</title>
    <link rel="stylesheet" href="../css/thanhtoan.css" />
</head>

<body>
    <form class="payment-form" action="/submit-order" method="POST">
        <h2>Thanh Toán Đơn Hàng</h2>

        <div class="form-group">
            <label for="fullname">Họ và Tên</label>
            <input type="text" id="fullname" name="fullname" placeholder="Nguyễn Văn A" required />
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="phone" name="phone" placeholder="0912xxxxxx" required pattern="[0-9]{9,11}" />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="email@example.com" required />
            </div>
        </div>

        <div class="form-group">
            <label for="address">Địa chỉ nhận hàng</label>
            <input type="text" id="address" name="address" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh" required />
        </div>

        <div class="form-group">
            <label for="payment-method">Phương thức thanh toán</label>
            <select id="payment-method" name="payment_method" required>
                <option value="" disabled selected>Chọn phương thức</option>
                <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                <option value="momo">Ví Momo</option>
                <option value="credit_card">Thẻ tín dụng / Thẻ ghi nợ</option>
            </select>
        </div>

        <button type="submit">Xác Nhận Thanh Toán</button>
    </form>
</body>

</html>