<?php
// Bắt đầu một session để lưu trữ thông báo hoặc dữ liệu tạm thời
session_start();

// Để đảm bảo chỉ xử lý khi có POST request gửi đến
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- 1. Lấy dữ liệu từ Form ---
    $fullname = $_POST['fullname'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $total_amount = $_POST['total_amount'] ?? 0; // Đảm bảo có input hidden total_amount trong form HTML

    // Giả sử thông tin sản phẩm được gửi dưới dạng mảng (như tôi đã ví dụ trong thanhtoan.html)
    $product_ids = $_POST['product_id'] ?? [];
    $product_names = $_POST['product_name'] ?? [];
    $product_prices = $_POST['product_price'] ?? [];
    $product_quantities = $_POST['product_quantity'] ?? [];

    // --- 2. Xử lý dữ liệu (Tính toán lại, kiểm tra dữ liệu) ---
    // Trong thực tế, bạn sẽ kiểm tra tính hợp lệ của dữ liệu ở đây.
    // Ví dụ: kiểm tra định dạng số điện thoại, địa chỉ không rỗng, v.v.
    // Quan trọng: Luôn tính toán lại tổng tiền ở backend để tránh gian lận từ phía client.
    $calculated_total_amount = 0;
    $order_products = []; // Mảng để lưu thông tin sản phẩm cho đơn hàng

    if (!empty($product_ids)) {
        for ($i = 0; $i < count($product_ids); $i++) {
            $p_id = htmlspecialchars($product_ids[$i]);
            $p_name = htmlspecialchars($product_names[$i]);
            $p_price = (float)htmlspecialchars($product_prices[$i]); // Chuyển đổi sang số thực
            $p_qty = (int)htmlspecialchars($product_quantities[$i]); // Chuyển đổi sang số nguyên

            // Tính toán tổng tiền dựa trên dữ liệu sản phẩm gửi lên
            $calculated_total_amount += ($p_price * $p_qty);

            // Lưu thông tin sản phẩm vào một mảng để dễ dàng insert vào database
            $order_products[] = [
                'product_id' => $p_id,
                'product_name' => $p_name,
                'price' => $p_price,
                'quantity' => $p_qty
            ];
        }
    }

    // So sánh total_amount từ frontend với calculated_total_amount
    // Nếu khác nhau, có thể là lỗi client hoặc gian lận. Bạn có thể xử lý ở đây.
    if (abs($calculated_total_amount - (float)$total_amount) > 0.01) { // Sử dụng độ sai số nhỏ cho số thực
        // Log lỗi hoặc xử lý khác
        error_log("Lỗi: Tổng tiền frontend không khớp với backend. Frontend: $total_amount, Backend: $calculated_total_amount");
        // Trong thực tế, bạn có thể dừng quá trình và trả về lỗi
        // echo "Có lỗi trong quá trình tính toán. Vui lòng thử lại.";
        // exit();
    }

    // --- 3. Kết nối Cơ sở dữ liệu và Lưu thông tin đơn hàng ---
    // Phần này chúng ta sẽ làm ở bước tiếp theo, sau khi bạn kiểm tra thành công việc nhận dữ liệu.
    // Tạm thời, chúng ta sẽ chỉ hiển thị dữ liệu và sau đó chuyển hướng.

    // --- 4. Phản hồi cho người dùng ---
    // Sau khi xử lý xong (lưu vào DB, v.v.), bạn nên chuyển hướng người dùng.
    // Ví dụ: Chuyển hướng đến một trang "Cảm ơn" hoặc trang xác nhận đơn hàng.

    $_SESSION['order_success'] = true; // Lưu một biến session để hiển thị thông báo thành công
    $_SESSION['order_details'] = [ // Lưu thông tin đơn hàng để hiển thị trên trang cảm ơn
        'fullname' => $fullname,
        'address' => $address,
        'phone' => $phone,
        'total_amount' => $calculated_total_amount,
        'products' => $order_products
    ];

    // Chuyển hướng đến trang cảm ơn hoặc xác nhận
    // Lưu ý: Đường dẫn này cần chính xác so với cấu trúc thư mục của bạn
    header("Location: /LTWEB/frontend/html/thankyou.html"); // Giả sử bạn có trang thankyou.html
    exit(); // Luôn gọi exit() sau header() để dừng việc thực thi script
} else {
    // Nếu không phải là POST request (người dùng truy cập trực tiếp file này)
    // Chuyển hướng về trang thanh toán hoặc trang chủ
    header("Location: /LTWEB/frontend/html/thanhtoan.html");
    exit();
}
?>