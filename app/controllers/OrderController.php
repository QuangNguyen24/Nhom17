<?php

class OrderController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        $user_id = $_SESSION['user_id'];

        $orderModel = $this->model('Order');
        $orders = $orderModel->getAllByUserId($user_id);

        $this->view('order/index', ['orders' => $orders]);
    }

    public function detail()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $order_id = intval($_GET['id'] ?? 0);

        $orderModel = $this->model('Order');
        $order = $orderModel->getByIdAndUser($order_id, $user_id);

        if (!$order) {
            echo "<div class='container mt-5'><h2>Không tìm thấy đơn hàng</h2></div>";
            return;
        }

        $details = $this->model('OrderDetail')->getDetailsByOrderId($order_id);

        $this->view('order/detail', [
            'order' => $order,
            'details' => $details
        ]);
    }

    public function cancel($id)
    {
        // Không cho người dùng tự ý hủy đơn hàng
        echo "<div class='container mt-5 text-danger'><h4>Không thể hủy đơn hàng.</h4></div>";
        return;

        // Nếu muốn cho phép lại, có thể dùng đoạn sau:
        
    //     if (!isset($_SESSION['user_id'])) {
    //         header('Location: ' . BASE_URL . '/auth/login');
    //         exit();
    //     }

    //     $user_id = intval($_SESSION['user_id']);
    //     $id = intval($id);

    //     $orderModel = $this->model('Order');
    //     $success = $orderModel->cancelOrderByUser($id, $user_id);

    //     header('Location: ' . BASE_URL . '/index.php?url=order/index');
        
    // }

    }
}