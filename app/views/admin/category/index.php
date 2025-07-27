<?php include_once __DIR__ . '/../../layouts/admin_header.php'; ?>

<div class="container mt-4 mb-5">
    <h2 class="mb-4"> Danh sách danh mục </h2>
    <a href="admin.php?url=category/add" class="btn btn-primary mb-3">Thêm </a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th width="70%">Tên danh mục</th>
                <th width="30%">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = \Database::connect();

            function show_children($conn, $parent_id, $level = 1) {
                $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                $query = mysqli_query($conn, "SELECT * FROM categories WHERE parent_id = $parent_id ORDER BY name ASC");
                while ($child = mysqli_fetch_assoc($query)) {
                    echo "<tr>
                            <td>{$indent}↳ " . htmlspecialchars($child['name']) . "</td>
                            <td>
                                <a href='admin.php?url=category/edit/{$child['id']}' class='btn btn-sm btn-warning'>Sửa</a>
                                <a href='admin.php?url=category/delete/{$child['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Xóa danh mục này?\")'>Xóa</a>
                            </td>
                          </tr>";
                    show_children($conn, $child['id'], $level + 1);
                }
            }

            foreach ($data['parents'] as $parent) {
                echo "<tr>
                        <td><strong>" . htmlspecialchars($parent['name']) . "</strong></td>
                        <td>
                            <a href='admin.php?url=category/edit/{$parent['id']}' class='btn btn-sm btn-warning'>Sửa</a>
                            <a href='admin.php?url=category/delete/{$parent['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Xóa danh mục này và toàn bộ danh mục con?\")'>Xóa</a>
                        </td>
                      </tr>";
                show_children($conn, $parent['id']);
            }
            ?>
        </tbody>
    </table>
</div>


