<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">Chi tiết đơn hàng #<?= $order['id'] ?></h2>

    <dl class="row">
        <dt class="col-sm-3">Họ tên:</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($order['fullname']) ?></dd>

        <dt class="col-sm-3">Email:</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($order['email']) ?></dd>

        <dt class="col-sm-3">Điện thoại:</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($order['phone']) ?></dd>

        <dt class="col-sm-3">Địa chỉ:</dt>
        <dd class="col-sm-9"><?= htmlspecialchars($order['address']) ?></dd>

        <dt class="col-sm-3">Trạng thái:</dt>
        <dd class="col-sm-9">
            <span class="<?= $order['status'] === 'hủy' ? 'text-danger' : 'text-info' ?>">
                <?= ucfirst($order['status']) ?>
            </span>
        </dd>
    </dl>

    <h4 class="mt-4">Danh sách sản phẩm</h4>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($details as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($item['image']) ?>" width="60" class="img-fluid rounded" alt="product"></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price']) ?> VND</td>
                        <td><?= number_format($subtotal) ?> VND</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-end fw-bold fs-5 mt-3 mb-4">
        Tổng cộng: <?= number_format($total) ?> VND
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
        <a href="<?= BASE_URL ?>/index.php?url=order/index" class="btn btn-secondary">
            ← Quay lại
        </a>

        
    </div>
    <div style="padding: 1.2rem;"></div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
