<?php include_once __DIR__ . '/../layouts/header.php'; ?>



<div class="container mt-5">
    <h2 class="mb-4">Lịch sử đơn hàng của bạn</h2>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Phương thức</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Xem chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                        <td><?= ucfirst($order['method_payment']) ?></td>
                        <td><?= ucfirst($order['status']) ?></td>
                        <td><?= number_format($order['total_price']) ?> VND</td>
                        <td>
                            <a href="<?= BASE_URL ?>/index.php?url=order/detail&id=<?= $order['id'] ?>" class="btn btn-sm btn-primary">
                                Xem
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
