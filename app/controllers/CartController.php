<?php


class CartController extends Controller
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['HTTP_REFERER']; 
            header("Location: " . BASE_URL . "/index.php?url=auth/login");
            exit();
        }   

        $cart = $_SESSION['cart'] ?? [];
        $products = [];

        if (!empty($cart)) {
            $productModel = $this->model('Product');

            foreach ($cart as $productId => $quantity) {
                $product = $productModel->findDetailById($productId);
                if ($product) {
                    $product['quantity'] = $quantity;
                    $products[] = $product;
                }
            }
        }

        $this->view('cart/index', ['products' => $products]);
    }

    public function add()
    {

        if (session_status() === PHP_SESSION_NONE) session_start();
                
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/index.php?url=auth/login");
            exit();
        }   


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = intval($_POST['product_id'] ?? 0);
            $quantity = max(1, intval($_POST['quantity'] ?? 1));

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] += $quantity;
            } else {
                $_SESSION['cart'][$productId] = $quantity;
            }

            header('Location: ' . BASE_URL . '/index.php?url=cart/index');
            exit;
        }
    }

    public function remove($id = 0)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id = intval($id);
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }

        header('Location: ' . BASE_URL . '/index.php?url=cart/index');
        exit;
    }

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $productId => $qty) {
                $qty = max(1, intval($qty));
                $_SESSION['cart'][$productId] = $qty;
            }
        }

        header('Location: ' . BASE_URL . '/index.php?url=cart/index');
        exit;
    }

    public function clear()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        unset($_SESSION['cart']);

        header('Location: ' . BASE_URL . '/index.php?url=cart/index');
        exit;
    }
}
