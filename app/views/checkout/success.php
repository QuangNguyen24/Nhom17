<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="success-box text-center bg-white shadow rounded p-4">
                <h2 class="text-success mb-3">Đặt hàng thành công!</h2>
                <p class="mb-1">Cảm ơn bạn đã đặt hàng tại <strong>Nexorevn</strong></p>
                <hr>
                <p><strong>Mã đơn hàng:</strong> #<?= $order['id'] ?></p>
                <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['fullname']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
                <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['method_payment']) ?></p>
                <p><strong>Tổng tiền:</strong>
                    <span class="text-danger fw-bold">VND <?= number_format($order['total_price']) ?></span>
                </p>
                <p><strong>Trạng thái:</strong>
                    <span class="<?= $order['status'] === 'da xac nhan' ? 'text-success' : 'text-warning' ?>">
                        <?= ucfirst($order['status']) ?>
                    </span>
                </p>
                <p><small class="text-muted">Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></small></p>
                <a href="<?= BASE_URL ?>/" class="btn btn-primary mt-4 w-100">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>


