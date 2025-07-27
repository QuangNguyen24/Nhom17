<?php
class HomeController extends Controller {
    public function index() {
    $bannerModel = $this->model('Banner');
    $productModel = $this->model('Product');

    $data = [
        'banners'  => $bannerModel->getActiveBanners(),
        'featured' => [
            'products' => $productModel->getFeatured(),
            'page' => 1,
            'total_pages' => 1
        ],
        'newest' => [
            'products' => $productModel->getNewest(),
            'page' => 1,
            'total_pages' => 1
        ],
        'discount' => [
            'products' => $productModel->getDiscounted(),
            'page' => 1,
            'total_pages' => 1
        ]
    ];

    $this->view('home/index', $data);
}

}
