<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4 mb-5">
    <h2 class="text-center mb-4"> Chỉnh Sửa </h2>

    <form method="post" class="col-md-6 mx-auto">
        <div class="mb-3">
            <label>Tên hãng</label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['brand']['name']) ?>" class="form-control" required>
        </div>
        <button class="btn btn-primary">Cập nhật</button>
        <a href="admin.php?url=brand/index" class="btn btn-secondary ms-2">Hủy</a>
    </form>
</div>

