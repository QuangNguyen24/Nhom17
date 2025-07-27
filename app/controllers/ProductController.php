<?php

class ProductController extends Controller {
    public function index() {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');
        $brandModel = $this->model('Brand');

        $categories = $categoryModel->getAll();
        $brands = $brandModel->getAll();

        $filters = [
            'category_id' => $_GET['category_id'] ?? 0,
            'brand_id' => $_GET['brand_id'] ?? 0,
            'price_range' => $_GET['price_range'] ?? '',
            'sort' => $_GET['sort'] ?? '',
            'keyword' => trim($_GET['keyword'] ?? ''),
            'rating' => $_GET['rating'] ?? 0,
            'page' => isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1,
        ];

        $productsData = $productModel->getFilteredProducts($filters);

        $this->view('user/products', [
            'products' => $productsData['products'],
            'total_pages' => $productsData['total_pages'],
            'filters' => $filters,
            'categories' => $categories,
            'brands' => $brands,
            'title' => $productsData['title'] ?? 'Tất cả sản phẩm',
        ]);
    }

    public function detail($id) {
        $productModel = $this->model('Product');
        $reviewModel = $this->model('Review');

        $product = $productModel->getDetail($id);
        if (!$product) {
            echo "Sản phẩm không tồn tại.";
            return;
        }

        $images = $productModel->getImages($id);
        $reviews = $reviewModel->getByProduct($id);
        $avg = $reviewModel->getAverage($id);

        $this->view('user/product_detail', [
            'product' => $product,
            'images' => $images,
            'additional_images' => $images,
            'reviews' => $reviews,
            'avg' => $avg
        ]);
    }

    // Dùng cho Ajax lọc (nếu cần)
    public function filterAjax() {
        header('Content-Type: text/html; charset=utf-8');

        $filters = [
            'category_id' => intval($_POST['category_id'] ?? 0),
            'brand_id'    => intval($_POST['brand_id'] ?? 0),
            'price_range' => $_POST['price_range'] ?? '',
            'sort'        => $_POST['sort'] ?? '',
            'keyword'     => trim($_POST['keyword'] ?? ''),
            'page'        => max(1, intval($_POST['page'] ?? 1)),
        ];

        $productModel = $this->model('Product');
        $productsData = $productModel->getFilteredProducts($filters);

        extract($productsData);
        require '../app/views/user/products.php';
    }

    public function byType() {
    $type = $_GET['type'] ?? '';
    $validTypes = ['featured', 'newest', 'discount'];

    if (!in_array($type, $validTypes)) {
        echo "Loại sản phẩm không hợp lệ.";
        return;
    }

    $productModel = $this->model('Product');
    $filters = [
        'page' => isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1,
    ];
    $productsData = $productModel->getByType($type, $filters);

    $this->view('user/product_by_type', [
    'products' => $productsData['products']->fetch_all(MYSQLI_ASSOC), // Thêm fetch_all để dễ dùng
    'total_pages' => $productsData['total_pages'],
    'page' => $filters['page'],
    'type' => $type,
    'title' => $productsData['title'],
]);
}

}
