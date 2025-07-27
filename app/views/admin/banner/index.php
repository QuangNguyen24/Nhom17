<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>
<div class="container">
    <h2 class="mb-3"> Quản lý Banner  </h2>
    <a href="admin.php?url=banner/add" class="btn btn-primary mb-3"> Thêm banner </a>

    <table class="table table-bordered">
        <tr>
            <th>Hình ảnh</th>
            <th>Tiêu đề</th>
            <th>Link</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($data['banners'] as $b) { ?>
        <tr>
            <td><img src="<?= BASE_URL ?>/../<?= $b['image'] ?>" width="100" class="img-thumbnail">
</td>
            <td><?= htmlspecialchars($b['title']) ?></td>
            <td><a href="<?= $b['link'] ?>" target="_blank"><?= $b['link'] ?></a></td>
            <td><?= $b['is_active'] ? 'Hiển thị' : 'Ẩn' ?></td>
            <td>
                <a href="admin.php?url=banner/edit/<?= $b['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="admin.php?url=banner/delete/<?= $b['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa banner này?')">Xóa</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

