<?php

namespace admin;

use Controller;

class ProductController extends Controller
{
    private function db()
    {
        require_once __DIR__ . '/../../core/Database.php';
        return \Database::connect();
    }

    private function create_slug($str)
    {
        $str = mb_strtolower(trim($str), 'UTF-8');
        $str = preg_replace('/[^a-z0-9\s-]/u', '', $str);
        $str = preg_replace('/[\s-]+/', '-', $str);
        return $str;
    }

    public function index()
    {
        $db = $this->db();
        $result = mysqli_query($db, "SELECT products.*, categories.name AS category_name, brands.name AS brand_name
                                     FROM products 
                                     LEFT JOIN categories ON products.category_id = categories.id
                                     LEFT JOIN brands ON products.brand_id = brands.id
                                     ORDER BY products.created_at DESC");
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $this->view('admin/product/index', ['products' => $products]);
    }

    public function add()
    {
        $db = $this->db();
        $categories = mysqli_fetch_all(mysqli_query($db, "SELECT * FROM categories ORDER BY name ASC"), MYSQLI_ASSOC);
        $brands = mysqli_fetch_all(mysqli_query($db, "SELECT * FROM brands ORDER BY name ASC"), MYSQLI_ASSOC);

        $this->view('admin/product/add', [
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function store()
    {
        $db = $this->db();

        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['original_price'];
        $discount_price = $_POST['discount_price'] ?: null;
        $category_id = $_POST['category_id'];
        $brand_id = $_POST['brand_id'];
        $is_featured = $_POST['is_featured'];

        $category_row = mysqli_fetch_assoc(mysqli_query($db, "SELECT name FROM categories WHERE id = $category_id"));
        $slug_category = $this->create_slug($category_row['name'] ?? 'khac');
        $slug_product = $this->create_slug($name);
        
        $upload_subdir = "$slug_category/$slug_product";
        $full_path = PUBLIC_PATH . '/' . UPLOAD_DIR . '/' . $upload_subdir;
        $image_url_path = UPLOAD_DIR . '/' . $upload_subdir;


        if (!file_exists($full_path)) mkdir($full_path, 0777, true);

        // Ảnh chính
        $image_main = '';
        if ($_FILES['main_image']['error'] === 0) {
            $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
            $filename = 'main_' . time() . '_' . uniqid() . '.' . $ext;
            $target = $full_path . '/' . $filename;
            if (move_uploaded_file($_FILES['main_image']['tmp_name'], $target)) {
                $image_main = $image_url_path . '/' . $filename;
            }
        }


        // Lưu DB
        $discount_sql = $discount_price !== null ? "'$discount_price'" : "NULL";
        $insert = "INSERT INTO products (name, description, price, discount_price, image, category_id, brand_id, is_featured)
                   VALUES ('$name', '$description', '$price', $discount_sql, '$image_main', '$category_id', '$brand_id', '$is_featured')";
        mysqli_query($db, $insert);
        $product_id = mysqli_insert_id($db);

        // Ảnh phụ
        foreach ($_FILES['additional_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['additional_images']['error'][$key] === 0) {
                $ext = pathinfo($_FILES['additional_images']['name'][$key], PATHINFO_EXTENSION);
                $filename = 'sub_' . time() . '_' . uniqid() . '.' . $ext;
                $target = $full_path . '/' . $filename;
                if (move_uploaded_file($tmp_name, $target)) {
                    $path = $image_url_path . '/' . $filename;
                    mysqli_query($db, "INSERT INTO product_images (product_id, image_path) VALUES ('$product_id', '$path')");
                }
            }
        }


        header("Location: admin.php?url=product/index");
        exit();
    }

    public function delete($id = null)
{
    if (!$id) {
        header("Location: admin.php?url=product/index");
        exit();
    }

    $db = $this->db();
    $id = intval($id);

    // Lấy ảnh chính
    $product = mysqli_fetch_assoc(mysqli_query($db, "SELECT image FROM products WHERE id = $id"));
    if ($product && !empty($product['image'])) {
        $main_image_path = PUBLIC_PATH . '/' . $product['image'];
        if (file_exists($main_image_path)) {
            unlink($main_image_path);
        }
    }

    // Lấy ảnh phụ
    $images = mysqli_fetch_all(mysqli_query($db, "SELECT image_path FROM product_images WHERE product_id = $id"), MYSQLI_ASSOC);
    foreach ($images as $img) {
        $path = PUBLIC_PATH . '/' . $img['image_path'];
        if (file_exists($path)) {
            unlink($path);
        }
    }

    // Xóa ảnh phụ trong DB
    mysqli_query($db, "DELETE FROM product_images WHERE product_id = $id");

    // Xóa sản phẩm
    mysqli_query($db, "DELETE FROM products WHERE id = $id");

    header("Location: admin.php?url=product/index");
    exit();
}


    public function edit()
    {
        $db = $this->db();
        $id = intval($_GET['id']);
        $product = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM products WHERE id = $id"));
        $images = mysqli_fetch_all(mysqli_query($db, "SELECT * FROM product_images WHERE product_id = $id"), MYSQLI_ASSOC);
        $categories = mysqli_fetch_all(mysqli_query($db, "SELECT * FROM categories ORDER BY name ASC"), MYSQLI_ASSOC);
        $brands = mysqli_fetch_all(mysqli_query($db, "SELECT * FROM brands ORDER BY name ASC"), MYSQLI_ASSOC);

        $this->view('admin/product/edit', compact('product', 'images', 'categories', 'brands'));
    }

    public function update()
{
    $db = $this->db();
    $id = intval($_POST['id']);

    $name = mysqli_real_escape_string($db, $_POST['name']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $price = floatval($_POST['original_price']);
    $discount_price = $_POST['discount_price'] !== '' ? floatval($_POST['discount_price']) : null;
    $category_id = intval($_POST['category_id']);
    $brand_id = intval($_POST['brand_id']);
    $is_featured = intval($_POST['is_featured']);

    $product = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM products WHERE id = $id"));
    if (!$product) {
        header("Location: admin.php?url=product/index");
        exit;
    }

    $image_main = $product['image'];

    // Tạo slug đường dẫn upload
    $slug_category = $this->create_slug(mysqli_fetch_assoc(mysqli_query($db, "SELECT name FROM categories WHERE id = $category_id"))['name'] ?? 'danh-muc');
    $slug_product = $this->create_slug($name);
    $upload_subdir = "$slug_category/$slug_product";
    $full_path = PUBLIC_PATH . '/' . UPLOAD_DIR . '/' . $upload_subdir;
    $relative_path = UPLOAD_DIR . '/' . $upload_subdir;

    if (!file_exists($full_path)) mkdir($full_path, 0777, true);

    // Ảnh chính mới
    if (!empty($_FILES['main_image']['name']) && $_FILES['main_image']['error'] === 0) {
        // Xóa ảnh cũ nếu có
        $old_path = PUBLIC_PATH . '/' . $image_main;
        if (file_exists($old_path)) unlink($old_path);

        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $filename = 'main_' . time() . '_' . uniqid() . '.' . $ext;
        $target = $full_path . '/' . $filename;
        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $target)) {
            $image_main = $relative_path . '/' . $filename;
        }
    }

    // Cập nhật sản phẩm
    $discount_sql = $discount_price !== null ? "'$discount_price'" : "NULL";
    $sql = "UPDATE products SET 
                name='$name',
                description='$description',
                price='$price',
                discount_price=$discount_sql,
                image='$image_main',
                category_id='$category_id',
                brand_id='$brand_id',
                is_featured='$is_featured'
            WHERE id = $id";
    mysqli_query($db, $sql);

    // Xóa ảnh phụ được chọn
    if (!empty($_POST['image_ids_to_delete'])) {
        foreach ($_POST['image_ids_to_delete'] as $imgId) {
            $imgRow = mysqli_fetch_assoc(mysqli_query($db, "SELECT image_path FROM product_images WHERE id = $imgId"));
            if ($imgRow && file_exists(PUBLIC_PATH . '/' . $imgRow['image_path'])) {
                unlink(PUBLIC_PATH . '/' . $imgRow['image_path']);
            }
            mysqli_query($db, "DELETE FROM product_images WHERE id = $imgId");
        }
    }

    // Upload thêm ảnh phụ mới
    if (!empty($_FILES['additional_images']['name'][0])) {
        foreach ($_FILES['additional_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['additional_images']['error'][$key] === 0) {
                $ext = pathinfo($_FILES['additional_images']['name'][$key], PATHINFO_EXTENSION);
                $filename = 'sub_' . time() . '_' . uniqid() . '.' . $ext;
                $target = $full_path . '/' . $filename;
                if (move_uploaded_file($tmp_name, $target)) {
                    $path = $relative_path . '/' . $filename;
                    mysqli_query($db, "INSERT INTO product_images (product_id, image_path) VALUES ('$id', '$path')");
                }
            }
        }
    }

    header("Location: admin.php?url=product/index");
    exit();
}

}
