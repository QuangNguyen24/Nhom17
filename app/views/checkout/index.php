<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4 text-primary">Xác nhận đơn hàng</h2>

    <form method="POST" action="<?= BASE_URL ?>/index.php?url=checkout/process">
        <div class="row gy-4">
            <!-- Thông tin người nhận -->
            <div class="col-lg-6">
                <h4 class="mb-3">Thông tin người nhận</h4>
                <div class="form-floating mb-3">
                    <input type="text" name="fullname" class="form-control" placeholder="Họ tên" required>
                    <label>Họ tên người nhận</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <label>Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" required>
                    <label>Số điện thoại</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea name="address" class="form-control" placeholder="Địa chỉ giao hàng" required style="height:100px;"></textarea>
                    <label>Địa chỉ giao hàng</label>
                </div>

                <h5 class="mt-4 mb-2">Phương thức thanh toán</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="method_payment" id="payment_cash" value="tiền mặt" checked>
                    <label class="form-check-label" for="payment_cash">Tiền mặt khi nhận</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="method_payment" id="payment_vnpay" value="vnpay">
                    <label class="form-check-label" for="payment_vnpay">Thanh toán qua Vnpay</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="method_payment" id="payment_bank" value="chuyển khoản">
                    <label class="form-check-label" for="payment_bank">Chuyển khoản ngân hàng</label>
                </div>

                <input type="hidden" name="total" value="<?= $total ?>">
                <button type="submit" class="btn btn-primary mt-4 w-100">Đặt hàng</button>
            </div>

            <!-- Giỏ hàng -->
            <div class="col-lg-6">
                <h4 class="mb-3">Giỏ hàng của bạn</h4>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                                <?php if (is_array($item) && isset($item['name'], $item['quantity'], $item['price'])): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td><?= number_format($item['quantity'] * $item['price']) ?> VND</td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <tr>
                                <th colspan="2" class="text-end">Tổng cộng</th>
                                <th class="text-danger "><?= number_format($total) ?> VND</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
