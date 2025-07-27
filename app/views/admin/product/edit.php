<?php include_once __DIR__ . '/../../layouts/admin_header.php';

$categories = $data['categories'] ?? [];
$brands = $data['brands'] ?? [];
$product = $data['product'] ?? null;
$images = $data['images'] ?? [];

if (!$product) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Không tìm thấy sản phẩm cần sửa!</div></div>";
    exit;
}
?>

<div class="container mt-4 mb-5">
    <h2 class="text-center mb-4">Chỉnh sửa sản phẩm</h2>

    <form method="post" enctype="multipart/form-data" action="admin.php?url=product/update">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">

        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Mô tả chi tiết</label>
            <textarea id="description" name="description" class="form-control"><?= $product['description'] ?></textarea>
        </div>

        <div class="mb-3">
            <label>Giá gốc</label>
            <input type="number" name="original_price" class="form-control" value="<?= $product['price'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Giá khuyến mãi</label>
            <input type="number" name="discount_price" class="form-control" value="<?= $product['discount_price'] ?>">
        </div>

        <!-- Ảnh chính hiện tại -->
        <div class="mb-3">
            <label>Ảnh chính hiện tại:</label><br>
            <?php if (!empty($product['image'])): ?>
                <img src="<?= BASE_URL ?>/../<?= $product['image'] ?>" width="150" class="img-thumbnail mb-2">
            <?php endif; ?>
            <input type="file" name="main_image" accept="image/*" class="form-control mt-2" onchange="previewMainImage(event)">
            <div id="main-image-preview" class="mt-2"></div>
        </div>

        <!-- Ảnh phụ hiện tại -->
        <div class="mb-3">
            <label>Ảnh phụ hiện tại:</label><br>
            <?php if (!empty($images)): ?>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($images as $img): ?>
                        <div class="position-relative" id="image-box-<?= $img['id'] ?>" style="display: inline-block;">
                            <img src="<?= BASE_URL ?>/../<?= $img['image_path'] ?>" width="100" class="img-thumbnail" style="z-index: 1;">
                            <button type="button"
                                    class="btn-close btn-sm position-absolute"
                                    style="top: 2px; right: 2px; z-index: 10; background-color: white; border-radius: 50%;"
                                    onclick="markImageForDeletion(<?= $img['id'] ?>)">
                            </button>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endif; ?>
            <div id="images-to-delete"></div>
        </div>

        <!-- Thêm ảnh phụ mới -->
        <div class="mb-3">
            <label>Thêm ảnh phụ mới:</label>
            <input type="file" name="additional_images[]" accept="image/*" multiple class="form-control" onchange="previewAdditionalImages(event)">
            <div id="additional-images-preview" class="d-flex flex-wrap gap-2 mt-2"></div>
        </div>

        <div class="mb-3">
            <label>Danh mục</label>
            <select name="category_id" class="form-select" required>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id'] == $product['category_id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Hãng sản xuất</label>
            <select name="brand_id" class="form-select" required>
                <?php foreach ($brands as $b): ?>
                    <option value="<?= $b['id'] ?>" <?= $b['id'] == $product['brand_id'] ? 'selected' : '' ?>><?= $b['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Sản phẩm nổi bật?</label>
            <select name="is_featured" class="form-select">
                <option value="0" <?= $product['is_featured'] == 0 ? 'selected' : '' ?>>Không</option>
                <option value="1" <?= $product['is_featured'] == 1 ? 'selected' : '' ?>>Có</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
        <a href="admin.php?url=product/index" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<!-- CKEditor + Preview Scripts -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#description')).catch(console.error);

function markImageForDeletion(imageId) {
    // Thêm input ẩn
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'image_ids_to_delete[]';
    input.value = imageId;
    document.getElementById('images-to-delete').appendChild(input);

    // Ẩn ảnh trên giao diện
    const box = document.getElementById('image-box-' + imageId);
    if (box) {
        box.style.opacity = '0.5';
        box.style.pointerEvents = 'none';
        box.title = 'Ảnh này sẽ bị xoá';
    }
}


function previewMainImage(event) {
    const preview = document.getElementById('main-image-preview');
    preview.innerHTML = '';
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.width = 150;
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
}

function previewAdditionalImages(event) {
    const preview = document.getElementById('additional-images-preview');
    preview.innerHTML = '';
    const files = event.target.files;
    for (let file of files) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.width = 100;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }
}
</script>
