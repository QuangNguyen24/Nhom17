<?php include_once __DIR__ . '/../../layouts/admin_header.php'; 

// Tách dữ liệu truyền từ controller
$categories = $data['categories'] ?? [];
$brands = $data['brands'] ?? [];

?>

<div class="container mt-4 mb-5">
    <h2 class="text-center mb-4">Thêm sản phẩm mới</h2>

    <?php if (empty($categories)): ?>
        <div class="alert alert-warning">⚠ Chưa có danh mục nào!</div>
    <?php endif; ?>
    <?php if (empty($brands)): ?>
        <div class="alert alert-warning">⚠ Chưa có hãng sản xuất nào!</div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" action="admin.php?url=product/store">
        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mô tả chi tiết</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Giá gốc</label>
            <input type="number" name="original_price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Giá khuyến mãi (nếu có)</label>
            <input type="number" name="discount_price" class="form-control">
        </div>

  

        <div class="mb-3">
            <label>Ảnh chính</label>
            <input type="file" name="main_image" accept="image/*" class="form-control" required onchange="previewMainImage(event)">
            <div id="mainImagePreview" class="mt-2"></div>
        </div>

        <div class="mb-3">
            <label>Ảnh phụ (nhiều)</label>
            <input type="file" name="additional_images[]" accept="image/*" multiple class="form-control" onchange="previewAdditionalImages(event)">
            <div id="additionalImagesPreview" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>


        <div class="mb-3">
            <label>Danh mục</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Hãng sản xuất</label>
            <select name="brand_id" class="form-select" required>
                <option value="">-- Chọn hãng --</option>
                <?php foreach ($brands as $b): ?>
                    <option value="<?= $b['id'] ?>"><?= $b['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Sản phẩm nổi bật?</label>
            <select name="is_featured" class="form-select">
                <option value="0">Không</option>
                <option value="1">Có</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
    </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));

function previewMainImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('mainImagePreview');
    preview.innerHTML = ''; // Clear cũ

    if (file) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = 'img-thumbnail';
        img.style.height = '200px';
        img.onload = () => URL.revokeObjectURL(img.src); // Dọn bộ nhớ
        preview.appendChild(img);
    }
}

function previewAdditionalImages(event) {
    const files = event.target.files;
    const preview = document.getElementById('additionalImagesPreview');
    preview.innerHTML = ''; // Clear cũ

    Array.from(files).forEach(file => {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = 'img-thumbnail';
        img.style.height = '150px';
        img.style.objectFit = 'cover';
        img.onload = () => URL.revokeObjectURL(img.src);
        preview.appendChild(img);
    });
}


</script>


