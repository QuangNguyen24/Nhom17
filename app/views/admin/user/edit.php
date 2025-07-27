<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<h2 class="mb-3"> Cập nhật người dùng</h2>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select">
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Người dùng</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Quản trị viên</option>
        </select>
    </div>

    <button type="submit" class="btn btn-warning"><i class="bi bi-pencil"></i> Cập nhật</button>
    <a href="admin.php?url=user/index" class="btn btn-secondary">Quay lại</a>
</form>


