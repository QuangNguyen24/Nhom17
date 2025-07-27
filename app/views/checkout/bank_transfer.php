<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h1 class="text-center">Thanh toán chuyển khoản ngân hàng</h1>
    <p>Vui lòng chuyển khoản số tiền: <strong>VND <?= number_format($order['total_price']); ?></strong></p>
    <p>Thông tin chuyển khoản:</p>
    <ul>
        <li>Ngân hàng: Techcombank</li>
        <li>Số tài khoản: 1903 6868 aaaa bb</li>
        <li>Chủ tài khoản: NGUYEN VAN A</li>
        <li>Nội dung chuyển khoản: <strong>HoTen _ SDT _ DonHang #<?= $order['id']; ?></strong></li>
    </ul>
    
    <a href="<?= BASE_URL ?>/index.php?url=checkout/success&order_id=<?= $order['id']; ?>" class="btn btn-primary mt-3">Xác nhận đã chuyển khoản</a>
</div>
<div style="padding: 1.5rem;"></div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
