<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4 mb-5">
    <h2 class="text-center mb-4"> Quản lý thương hiệu </h2>

    <form method="post" class="row g-3 mb-4">
        <div class="col-md-9">
            <input type="text" name="name" class="form-control" placeholder="Nhập tên hãng mới..." required>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">Thêm nhà sản xuất</button>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead class="table-secondary">
            <tr>
                <th>ID</th>
                <th>Tên hãng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['brands'] as $brand): ?>
            <tr>
                <td><?= $brand['id'] ?></td>
                <td><?= htmlspecialchars($brand['name']) ?></td>
                <td>
                    <a href="admin.php?url=brand/edit/<?= $brand['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="admin.php?url=brand/index&delete=<?= $brand['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa hãng này?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
