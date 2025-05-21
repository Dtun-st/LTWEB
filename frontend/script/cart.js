// Hàm hiển thị giỏ hàng
function displayCart() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartTable = document.getElementById("cartTable");
    let total = 0;

    if (cart.length === 0) {
        cartTable.innerHTML = '<tr><td colspan="5" class="kqTdGH">Không có sản phẩm nào trong giỏ hàng.</td></tr>';
        document.getElementById("totalPrice").textContent = "Tổng tiền: 0 đ";
        return;
    }

    cartTable.innerHTML = cart.map((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        return `
            <tr>
                <td class="tdGH">
                    <img src="${item.image}" alt="${item.name}">
                    <div>
                        <p class="tenSpGh">${item.name}</p>
                        <p>Phân loại: <strong>${item.category || "Không rõ"}</strong></p>
                    </div>
                </td>
                <td>
                    <span class="price">${item.price.toLocaleString()} đ</span>
                    ${item.oldPrice ? `<span class="old-price">${item.oldPrice.toLocaleString()} đ</span>` : ''}
                </td>
                <td>
                    <div class="quantity-control">
                        <button onclick="decreaseQuantity(${index})">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="increaseQuantity(${index})">+</button>
                    </div>
                </td>
                <td class="action-column">
                    <button class="xoa" onclick="removeItem(${index})">Xóa</button>
                    <a class="tim-tuong-tu" href="#">Tìm sản phẩm tương tự</a>
                </td>
                <td>
                    <span class="price">${itemTotal.toLocaleString()} đ</span>
                </td>
            </tr>
        `;
    }).join("");

    document.getElementById("totalPrice").textContent = "Tổng tiền: " + total.toLocaleString() + " đ";
}

// Hàm tăng số lượng sản phẩm
function increaseQuantity(index) {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart[index].quantity += 1;
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
}

// Hàm giảm số lượng sản phẩm
function decreaseQuantity(index) {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    if (cart[index].quantity > 1) {
        cart[index].quantity -= 1;
        localStorage.setItem("cart", JSON.stringify(cart));
        displayCart();
    }
}

// Hàm xóa sản phẩm khỏi giỏ hàng
function removeItem(index) {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
}

// Hàm hiển thị form thanh toán
function showPaymentForm() {
    document.getElementById('cartSection').style.display = 'none';
    document.getElementById('paymentForm').style.display = 'block';
}

// Khi trang tải, hiển thị giỏ hàng
window.onload = displayCart;
