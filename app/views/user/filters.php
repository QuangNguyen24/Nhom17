<!-- Nút Toggle chỉ hiển thị trên mobile -->
<button class="btn btn-outline-secondary d-md-none mb-3 w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
Lọc sản phẩm
</button>

<!-- Bộ lọc có thể ẩn/hiện -->
<div class="collapse d-md-block" id="filterCollapse">
    <form method="GET" action="index.php">
        <input type="hidden" name="url" value="product/index">

        <div class="row">
            <!-- Tìm kiếm -->
            <div class="mb-3 col-12">
                <label class="form-label">Từ khóa</label>
                <input type="text" name="keyword" class="form-control" placeholder="Nhập tên sản phẩm..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            </div>

            <!-- Danh mục -->
            <div class="mb-3 col-md-12">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-select">
                    <option value="">-- Tất cả --</option>
                    <?php
                    foreach ($categories as $parent) {
                        if ($parent['parent_id'] == 0) {
                            $selected = ($filters['category_id'] ?? '') == $parent['id'] ? 'selected' : '';
                            echo "<option value='{$parent['id']}' $selected>" . htmlspecialchars($parent['name']) . "</option>";

                            // Hiển thị danh mục con
                            foreach ($categories as $child) {
                                if ($child['parent_id'] == $parent['id']) {
                                    $selectedChild = ($filters['category_id'] ?? '') == $child['id'] ? 'selected' : '';
                                    echo "<option value='{$child['id']}' $selectedChild>&nbsp;&nbsp;&nbsp;↳ " . htmlspecialchars($child['name']) . "</option>";
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>


            <!-- Hãng -->
            <div class="mb-3 col-md-12">
                <label class="form-label">Hãng</label>
                <select name="brand_id" class="form-select">
                    <option value="">-- Tất cả --</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand['id'] ?>" <?= ($filters['brand_id'] ?? '') == $brand['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($brand['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Khoảng giá -->
            <div class="mb-3 col-md-12">
                <label class="form-label">Khoảng giá</label>
                <select name="price_range" class="form-select">
                    <option value="">-- Tất cả --</option>
                    <option value="0-1000000" <?= ($filters['price_range'] ?? '') == '0-1000000' ? 'selected' : '' ?>>Dưới 1.000.000 VND</option>
                    <option value="1000000-5000000" <?= ($filters['price_range'] ?? '') == '1000000-5000000' ? 'selected' : '' ?>>1.000.000 VND - 5.000.000 VND</option>
                    <option value="5000000-999999999" <?= ($filters['price_range'] ?? '') == '5000000-999999999' ? 'selected' : '' ?>>Trên 5.000.000 VND</option>
                </select>
            </div>

            <!-- Đánh giá -->
            <div class="mb-3 col-md-12">
                <label class="form-label">Đánh giá tối thiểu</label>
                <select name="rating" class="form-select">
                    <option value="0">-- Tất cả --</option>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>" <?= ($filters['rating'] ?? 0) == $i ? 'selected' : '' ?>>Từ <?= $i ?> sao</option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Sắp xếp -->
            <div class="mb-3 col-md-12">
                <label class="form-label">Sắp xếp</label>
                <select name="sort" class="form-select">
                    <option value="">-- Mặc định --</option>
                    <option value="price_asc" <?= ($filters['sort'] ?? '') == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                    <option value="price_desc" <?= ($filters['sort'] ?? '') == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                    <option value="name_asc" <?= ($filters['sort'] ?? '') == 'name_asc' ? 'selected' : '' ?>>Tên A-Z</option>
                    <option value="name_desc" <?= ($filters['sort'] ?? '') == 'name_desc' ? 'selected' : '' ?>>Tên Z-A</option>
                </select>
            </div>
        </div>

        <div  class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary w-100"> Lọc </button>
         <a href="index.php?url=product/index" class="btn btn-secondary w-100">Xóa bộ lọc</a>
        </div>
        
    </form>
</div>
