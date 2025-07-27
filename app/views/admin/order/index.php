<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4">
    <h2>Danh sách đơn hàng</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <ID>ID</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['fullname'] ?></td>
                <td><?= $order['created_at'] ?></td>
                <td><?= ucfirst($order['status']) ?></td>
                <td>
                    <a href="admin.php?url=order/detail/<?= $order['id'] ?>" class="btn btn-sm btn-primary">Chi tiết</a>
                    <hr style="width: 100px">
                    <form method="POST" action="admin.php?url=order/updateStatus">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                            <?php
                            $statuses = ['đang chờ', 'đã xác nhận', 'đang vận chuyển', 'đã nhận hàng', 'hủy'];
                            foreach ($statuses as $status) {
                                $selected = $order['status'] === $status ? 'selected' : '';
                                echo "<option value=\"$status\" $selected>" . ucfirst($status) . "</option>";
                            }
                            ?>
                        </select>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
