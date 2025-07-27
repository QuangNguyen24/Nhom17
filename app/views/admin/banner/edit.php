<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<div class="container my-5">
    <h3 class="text-center mb-4"> Chỉnh sửa </h3>

    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <!-- Ảnh hiện tại -->
                <div class="mb-3 text-center">
                    <label class="form-label fw-bold">Ảnh hiện tại</label><br>
                    <?php if (!empty($data['banner']['image'])): ?>
                        <img src="<?= BASE_URL?>/../<?= $data['banner']['image'] ?>" alt="banner" class="img-fluid rounded shadow-sm" style="max-height: 250px;">
                   
                        <?php else: ?>
                        <div class="text-muted">Chưa có ảnh</div>
                    <?php endif; ?>
                </div>

                <!-- Upload ảnh mới -->
                <div class="mb-3">
                    <label class="form-label">Ảnh mới (nếu muốn thay đổi)</label>
                    <input type="file" name="image" class="form-control" accept="image/*" id="imageInput">
                    <img id="imagePreview" class="img-fluid mt-2 d-none rounded shadow-sm" style="max-height: 250px;">
                </div>

                <!-- Tiêu đề -->
                <div class="mb-3">
                    <label class="form-label">Tiêu đề</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($data['banner']['title']) ?>" required>
                </div>

                <!-- Link -->
                <div class="mb-3">
                    <label class="form-label">Link</label>
                    <input type="url" name="link" class="form-control" value="<?= htmlspecialchars($data['banner']['link']) ?>">
                </div>

                <!-- Trạng thái -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                        <?= !empty($data['banner']['is_active']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">Hiển thị</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100">
                     Cập nhật 
                </button>
            </form>
        </div>
    </div>
</div>

<!-- JS preview ảnh -->
<script>
document.getElementById('imageInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    if (file && file.type.startsWith('image/')) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    } else {
        preview.src = '';
        preview.classList.add('d-none');
    }
});
</script>
