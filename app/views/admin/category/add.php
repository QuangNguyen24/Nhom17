<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<h2>Thêm danh mục sản phẩm </h2>
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Tên danh mục</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Danh mục cha (nếu có)</label>
        <select name="parent_id" class="form-select">
            <option value="">-- Không có (Danh mục gốc) --</option>
            <?php while ($row = mysqli_fetch_assoc($data['parents'])): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Lưu danh mục</button>
    <a href="admin.php?url=category/index" class="btn btn-secondary">Quay lại</a>
</form>

