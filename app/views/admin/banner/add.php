<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<div class="container my-4">
    <h3 class="mb-3"> Thêm banner </h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Chọn ảnh banner</label>
            <input type="file" name="image" class="form-control" accept="image/*" required onchange="previewImage(event)">
             <img id="preview" src="#" alt="Preview" style="display:none; max-width: 300px; margin-top: 10px;" class="img-thumbnail">
        </div>
        <div class="mb-3">
            <label class="form-label">Tiêu đề</label>
            <input type="text" name="title" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Link liên kết</label>
            <input type="text" name="link" class="form-control">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" checked>
            <label class="form-check-label">Hiển thị</label>
        </div>
        <button type="submit" class="btn btn-primary">Lưu banner</button>
        <a href="admin.php?url=banner/index" class="btn btn-secondary">← Trở lại</a>
    </form>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

