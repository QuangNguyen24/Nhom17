<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Quản lý sản phẩm</h1>
    <a href="admin.php?url=product/add" class="btn btn-primary mb-3">Thêm </a>

    <?php if (!isset($products)): ?>
        <div class="alert alert-danger"> Biến <code>$products</code> chưa được truyền từ controller!</div>
    <?php elseif (empty($products)): ?>
        <div class="alert alert-warning"> Không có sản phẩm nào trong hệ thống!</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Danh mục</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="text-center"><?= $product['id'] ?></td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td class="text-end">VND <?= number_format($product['price'], 0, ',', '.') ?></td>
                            <td class="text-center">
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?= BASE_URL . '/../' . htmlspecialchars($product['image']) ?>" class="img-fluid img-thumbnail" style="max-width: 120px;">
                                <?php else: ?>
                                    <span class="text-muted">Không có ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($product['category_name'] ?? 'Chưa có') ?></td>
                            <td class="text-center">
                                <a href="admin.php?url=product/edit&id=<?= $product['id'] ?>" class="btn btn-sm btn-warning mb-1"> Sửa</a><br>
                                <hr style="width: 100px">
                                <a href="admin.php?url=product/delete/<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')"> Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a href="admin.php" class="btn btn-outline-secondary mt-3">← Quay lại trang quản trị</a>
</div>
