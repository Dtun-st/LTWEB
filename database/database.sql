CREATE DATABASE IF NOT EXISTS ban_hang_dien_tu;
USE ban_hang_dien_tu;

-- Bảng danh mục sản phẩm
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Thêm danh mục mẫu
INSERT INTO categories (name) VALUES
('Điện thoại'),
('Laptop'),
('Phụ kiện');

-- Bảng sản phẩm
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(15,2) NOT NULL,
    image VARCHAR(255),
    category_id INT,
    stock INT DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

INSERT INTO products (name, description, price, image, category_id, stock) VALUES
('iPhone 15 Pro Max', 'Hàng chính hãng Apple, màu titan', 33990000, 'iphone15.jpg', 1, 15),
('Laptop Dell XPS 13', 'Mỏng nhẹ, pin lâu, core i7 gen 12', 25990000, 'dellxps13.jpg', 2, 8),
('Tai nghe Bluetooth Sony', 'Chống ồn, pin 30 giờ', 1990000, 'sonyheadset.jpg', 3, 20);

-- Bảng người dùng
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    image VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user'
);

INSERT INTO users (username, password, email, role) VALUES
('admin', MD5('admin123'), 'admin@gmail.com', 'admin'),
('user1', MD5('123456'), 'user1@gmail.com', 'user');

-- Bảng đơn hàng
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_price DECIMAL(15,2),
    status VARCHAR(50) DEFAULT 'Đang xử lý',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Bảng chi tiết đơn hàng
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(15,2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
