<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<h2 class="mb-3">Thêm người dùng </h2>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select">
            <option value="user">Người dùng</option>
            <option value="admin">Quản trị viên</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu</button>
    <a href="admin.php?url=user/index" class="btn btn-secondary">Quay lại</a>
</form>

