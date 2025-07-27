<?php
    include_once __DIR__ . '/../../layouts/admin_header.php';
?>

<h2>Danh sách người dùng</h2>
<a href="admin.php?url=user/add" class="btn btn-primary mb-3"> Thêm  </a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td>
                <a href="admin.php?url=user/edit/<?= $user['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                <a href="admin.php?url=user/delete/<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xoá?')">Xoá</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

