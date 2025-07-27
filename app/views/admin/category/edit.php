<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<h2> Chỉnh sửa danh mục</h2>
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Tên danh mục</label>
        <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($data['category']['name']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Danh mục cha (nếu có)</label>
        <select name="parent_id" class="form-select">
            <option value="">-- Không có --</option>
            <?php while ($p = mysqli_fetch_assoc($data['parents'])): ?>
                <option value="<?= $p['id'] ?>" <?= $data['category']['parent_id'] == $p['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    <a href="admin.php?url=category/index" class="btn btn-secondary">Quay lại</a>
</form>

