<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<div class="container mt-4">
    <h2>Danh sách liên hệ </h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th> Mã liên hệ</th>
                <th>Khách hàng</th>
                <th> Email </th>
                <th> Nội dung </th>
                <th> Thời gian </th>
            </tr>
        </thead>
        <tbody>
             <?php foreach ($contacts as $row): ?>
                <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['fullname']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



