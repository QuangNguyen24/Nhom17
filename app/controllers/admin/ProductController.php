<?php

namespace admin;

use Controller;
use PDO;

class ProductController extends Controller
{
    private function db()
    {
        require_once __DIR__ . '/../../core/Database.php';
        return \Database::connect(); // PDO connection
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
        $stmt = $db->query("
            SELECT p.*, c.name AS category_name, b.name AS brand_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            ORDER BY p.created_at DESC
        ");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->view('admin/product/index', ['products' => $products]);
    }

    public function add()
    {
        $db = $this->db();
        $categories = $db->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
        $brands = $db->query("SELECT * FROM brands ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

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
        $discount_price = $_POST['discount_price'] !== '' ? $_POST['discount_price'] : null;
        $category_id = $_POST['category_id'];
        $brand_id = $_POST['brand_id'];
        $is_featured = $_POST['is_featured'];

        // Slug
        $category_stmt = $db->prepare("SELECT name FROM categories WHERE id = :id");
        $category_stmt->execute(['id' => $category_id]);
        $category_row = $category_stmt->fetch(PDO::FETCH_ASSOC);
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

        // Insert
        $stmt = $db->prepare("
            INSERT INTO products (name, description, price, discount_price, image, category_id, brand_id, is_featured)
            VALUES (:name, :description, :price, :discount_price, :image, :category_id, :brand_id, :is_featured)
            RETURNING id
        ");
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'discount_price' => $discount_price,
            'image' => $image_main,
            'category_id' => $category_id,
            'brand_id' => $brand_id,
            'is_featured' => $is_featured
        ]);
        $product_id = $stmt->fetchColumn();

        // Ảnh phụ
        foreach ($_FILES['additional_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['additional_images']['error'][$key] === 0) {
                $ext = pathinfo($_FILES['additional_images']['name'][$key], PATHINFO_EXTENSION);
                $filename = 'sub_' . time() . '_' . uniqid() . '.' . $ext;
                $target = $full_path . '/' . $filename;
                if (move_uploaded_file($tmp_name, $target)) {
                    $path = $image_url_path . '/' . $filename;
                    $stmtImg = $db->prepare("INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :image_path)");
                    $stmtImg->execute(['product_id' => $product_id, 'image_path' => $path]);
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

        // Xoá ảnh chính
        $stmt = $db->prepare("SELECT image FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($product && !empty($product['image'])) {
            $main_image_path = PUBLIC_PATH . '/' . $product['image'];
            if (file_exists($main_image_path)) {
                unlink($main_image_path);
            }
        }

        // Xoá ảnh phụ
        $stmt = $db->prepare("SELECT image_path FROM product_images WHERE product_id = :id");
        $stmt->execute(['id' => $id]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $img) {
            $path = PUBLIC_PATH . '/' . $img['image_path'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $db->prepare("DELETE FROM product_images WHERE product_id = :id")->execute(['id' => $id]);
        $db->prepare("DELETE FROM products WHERE id = :id")->execute(['id' => $id]);

        header("Location: admin.php?url=product/index");
        exit();
    }

    public function edit()
    {
        $db = $this->db();
        $id = intval($_GET['id']);

        $stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $db->prepare("SELECT * FROM product_images WHERE product_id = :id");
        $stmt->execute(['id' => $id]);
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = $db->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
        $brands = $db->query("SELECT * FROM brands ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/product/edit', compact('product', 'images', 'categories', 'brands'));
    }

    public function update()
    {
        $db = $this->db();
        $id = intval($_POST['id']);

        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['original_price'];
        $discount_price = $_POST['discount_price'] !== '' ? $_POST['discount_price'] : null;
        $category_id = $_POST['category_id'];
        $brand_id = $_POST['brand_id'];
        $is_featured = $_POST['is_featured'];

        $stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $image_main = $product['image'];

        $stmt = $db->prepare("SELECT name FROM categories WHERE id = :id");
        $stmt->execute(['id' => $category_id]);
        $slug_category = $this->create_slug($stmt->fetchColumn() ?? 'danh-muc');
        $slug_product = $this->create_slug($name);
        $upload_subdir = "$slug_category/$slug_product";
        $full_path = PUBLIC_PATH . '/' . UPLOAD_DIR . '/' . $upload_subdir;
        $relative_path = UPLOAD_DIR . '/' . $upload_subdir;
        if (!file_exists($full_path)) mkdir($full_path, 0777, true);

        if (!empty($_FILES['main_image']['name']) && $_FILES['main_image']['error'] === 0) {
            $old_path = PUBLIC_PATH . '/' . $image_main;
            if (file_exists($old_path)) unlink($old_path);

            $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
            $filename = 'main_' . time() . '_' . uniqid() . '.' . $ext;
            $target = $full_path . '/' . $filename;
            if (move_uploaded_file($_FILES['main_image']['tmp_name'], $target)) {
                $image_main = $relative_path . '/' . $filename;
            }
        }

        $stmt = $db->prepare("
            UPDATE products SET
                name = :name,
                description = :description,
                price = :price,
                discount_price = :discount_price,
                image = :image,
                category_id = :category_id,
                brand_id = :brand_id,
                is_featured = :is_featured
            WHERE id = :id
        ");
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'discount_price' => $discount_price,
            'image' => $image_main,
            'category_id' => $category_id,
            'brand_id' => $brand_id,
            'is_featured' => $is_featured,
            'id' => $id
        ]);

        // Xóa ảnh phụ
        if (!empty($_POST['image_ids_to_delete'])) {
            foreach ($_POST['image_ids_to_delete'] as $imgId) {
                $imgStmt = $db->prepare("SELECT image_path FROM product_images WHERE id = :id");
                $imgStmt->execute(['id' => $imgId]);
                $imgRow = $imgStmt->fetch(PDO::FETCH_ASSOC);
                if ($imgRow && file_exists(PUBLIC_PATH . '/' . $imgRow['image_path'])) {
                    unlink(PUBLIC_PATH . '/' . $imgRow['image_path']);
                }
                $db->prepare("DELETE FROM product_images WHERE id = :id")->execute(['id' => $imgId]);
            }
        }

        // Thêm ảnh phụ mới
        if (!empty($_FILES['additional_images']['name'][0])) {
            foreach ($_FILES['additional_images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['additional_images']['error'][$key] === 0) {
                    $ext = pathinfo($_FILES['additional_images']['name'][$key], PATHINFO_EXTENSION);
                    $filename = 'sub_' . time() . '_' . uniqid() . '.' . $ext;
                    $target = $full_path . '/' . $filename;
                    if (move_uploaded_file($tmp_name, $target)) {
                        $path = $relative_path . '/' . $filename;
                        $db->prepare("INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :path)")
                           ->execute(['product_id' => $id, 'path' => $path]);
                    }
                }
            }
        }

        header("Location: admin.php?url=product/index");
        exit();
    }
}
