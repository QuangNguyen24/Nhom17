<?php

namespace admin;

use Controller;

class BannerController extends Controller {
    public function index() {
        require_once __DIR__ . '/../../core/Database.php';
        $db = \Database::connect();

        $result = mysqli_query($db, "SELECT * FROM banners ORDER BY created_at DESC");
        $banners = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $banners[] = $row;
        }

        $this->view('admin/banner/index', ['banners' => $banners]);
    }

    public function add() {
        require_once __DIR__ . '/../../core/Database.php';
        $db = \Database::connect();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title     = mysqli_real_escape_string($db, $_POST['title']);
            $link      = mysqli_real_escape_string($db, $_POST['link']);
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            $image_path = '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $filename = time() . '_' . basename($_FILES['image']['name']);
                $image_path = 'images/banner/' . $filename;
                $target = '../public/' . $image_path;  // đảm bảo ảnh vào public/

                move_uploaded_file($_FILES['image']['tmp_name'], $target);
            }

            $query = "INSERT INTO banners (image, title, link, is_active) 
                      VALUES ('$image_path', '$title', '$link', $is_active)";
            mysqli_query($db, $query);

            header('Location: admin.php?url=banner/index');
            exit();
        }

        $this->view('admin/banner/add');
    }

    public function edit($id = 0) {
    require_once __DIR__ . '/../../core/Database.php';
    $db = \Database::connect();
    $id = intval($id);

    $result = mysqli_query($db, "SELECT * FROM banners WHERE id = $id");
    $banner = mysqli_fetch_assoc($result);

    if (!$banner) {
        echo "Không tìm thấy banner.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $link = mysqli_real_escape_string($db, $_POST['link']);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $image_path = $banner['image']; // mặc định giữ ảnh cũ

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file_type = $_FILES['image']['type'];
            $file_size = $_FILES['image']['size'];
            $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
            $max_size = 2 * 1024 * 1024;

            if (!in_array($file_type, $allowed_types)) {
                die("<script>alert('Chỉ chấp nhận JPG, PNG'); window.history.back();</script>");
            }

            if ($file_size > $max_size) {
                die("<script>alert('Ảnh quá lớn (>2MB)'); window.history.back();</script>");
            }

            $filename = time() . '_' . basename($_FILES['image']['name']);
            $target = 'images/banner/' . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], '../' . $target)) {
                if (file_exists('../' . $banner['image'])) {
                    unlink('../' . $banner['image']);
                }
                $image_path = $target;
            }
        }

        $query = "UPDATE banners 
                  SET image='$image_path', title='$title', link='$link', is_active=$is_active 
                  WHERE id = $id";
        mysqli_query($db, $query);
        header('Location: admin.php?url=banner/index');
        exit();
    }

    $this->view('admin/banner/edit', ['banner' => $banner]);
}

public function delete($id = 0) {
    require_once __DIR__ . '/../../core/Database.php';
    $db = \Database::connect();
    $id = intval($id);

    // Xóa file ảnh nếu có
    $res = mysqli_query($db, "SELECT image FROM banners WHERE id = $id");
    $data = mysqli_fetch_assoc($res);
    if ($data && file_exists('../' . $data['image'])) {
        unlink('../' . $data['image']);
    }

    mysqli_query($db, "DELETE FROM banners WHERE id = $id");
    header('Location: admin.php?url=banner/index');
    exit();
}

}
