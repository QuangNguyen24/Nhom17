<?php

namespace admin;

use Controller;

class CategoryController extends Controller {
    public function index() {
        require_once __DIR__ . '/../../core/Database.php';
        $db = \Database::connect();

        // Chỉ lấy danh mục cha (parent_id = NULL)
        $parents = mysqli_query($db, "SELECT * FROM categories WHERE parent_id IS NULL ORDER BY name ASC");
        $categories = [];

        while ($row = mysqli_fetch_assoc($parents)) {
            // Gán thêm danh sách con cho mỗi danh mục cha
            $row['children'] = mysqli_query($db, "SELECT * FROM categories WHERE parent_id = " . $row['id']);
            $categories[] = $row;
        }

        $this->view('admin/category/index', ['parents' => $categories]);
    }

    public function add() {
        require_once __DIR__ . '/../../core/Database.php';
        $db = \Database::connect();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = mysqli_real_escape_string($db, $_POST['name']);
            $parent_id = !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : 'NULL';

            $sql = "INSERT INTO categories (name, parent_id) VALUES ('$name', $parent_id)";
            mysqli_query($db, $sql);
            header('Location: admin.php?url=category/index');
            exit();
        }

        $parent_options = mysqli_query($db, "SELECT * FROM categories WHERE parent_id IS NULL ORDER BY name ASC");
        $this->view('admin/category/add', ['parents' => $parent_options]);
    }

    public function edit($id = 0) {
        require_once __DIR__ . '/../../core/Database.php';
        $db = \Database::connect();
        $id = intval($id);

        $category = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM categories WHERE id = $id"));
        if (!$category) {
            echo "Danh mục không tồn tại.";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = mysqli_real_escape_string($db, $_POST['name']);
            $new_parent_id = isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? intval($_POST['parent_id']) : 'NULL';

            // Không cho phép gán chính mình làm cha
            if ($new_parent_id == $id) {
                echo "<script>alert('❌ Không thể gán chính danh mục làm cha của chính nó.'); window.history.back();</script>";
                exit;
            }

            // Nếu danh mục hiện tại là parent (parent_id NULL) → không cho đổi parent_id
            if ($category['parent_id'] === NULL && $new_parent_id !== 'NULL') {
                echo "<script>alert('❌ Không thể chuyển danh mục gốc thành danh mục con.'); window.history.back();</script>";
                exit;
            }

            $sql = "UPDATE categories SET name = '$name', parent_id = $new_parent_id WHERE id = $id";
            mysqli_query($db, $sql);
            header('Location: admin.php?url=category/index');
            exit();
        }

        $parent_options = mysqli_query($db, "SELECT * FROM categories WHERE id != $id AND parent_id IS NULL ORDER BY name ASC");

        $this->view('admin/category/edit', [
            'category' => $category,
            'parents' => $parent_options
        ]);
    }

    public function delete($id = 0) {
        require_once __DIR__ . '/../../core/Database.php';
        $db = \Database::connect();
        $id = intval($id);

        // Xóa tất cả danh mục con nếu có
        mysqli_query($db, "DELETE FROM categories WHERE parent_id = $id");
        mysqli_query($db, "DELETE FROM categories WHERE id = $id");

        header('Location: admin.php?url=category/index');
        exit();
    }
}
