<?php

namespace admin;

use Controller;

class BrandController extends Controller {
    public function index() {
        require_once __DIR__ . '/../../core/Database.php';
        $db = \Database::connect();

        // Thêm brand mới
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
            $name = trim($_POST['name']);
            if ($name !== '') {
                mysqli_query($db, "INSERT INTO brands (name) VALUES ('$name')");
                header("Location: admin.php?url=brand/index");
                exit();
            }
        }

        // Xóa brand (an toàn)
        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            // Kiểm tra brand có đang được dùng không
            $check = mysqli_query($db, "SELECT COUNT(*) AS total FROM products WHERE brand_id = $id");
            $count = mysqli_fetch_assoc($check)['total'];

            if ($count > 0) {
                echo "<script>alert('Không thể xóa. Có $count sản phẩm đang dùng hãng này.'); window.location.href='admin.php?url=brand/index';</script>";
                exit;
            }

            mysqli_query($db, "DELETE FROM brands WHERE id = $id");
            header("Location: admin.php?url=brand/index");
            exit();
        }

        // Lấy danh sách brand
        $result = mysqli_query($db, "SELECT * FROM brands ORDER BY id DESC");
        $brands = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $brands[] = $row;
        }

        $this->view('admin/brand/index', ['brands' => $brands]);
    }

    public function edit($id = 0) {
        require_once __DIR__ . '/../../core/Database.php';
        $db = \Database::connect();
        $id = intval($id);

        $brand = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM brands WHERE id = $id"));
        if (!$brand) {
            echo "Không tìm thấy hãng.";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
            $name = trim($_POST['name']);
            if ($name !== '') {
                mysqli_query($db, "UPDATE brands SET name = '$name' WHERE id = $id");
                header("Location: admin.php?url=brand/index");
                exit();
            }
        }

        $this->view('admin/brand/edit', ['brand' => $brand]);
    }
}
