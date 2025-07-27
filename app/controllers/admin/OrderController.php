<?php
// File: app/controllers/admin/OrderController.php

namespace admin;

use Controller;

class OrderController extends Controller
{
    public function index()
    {
        $this->requireAdmin();
        $orderModel = $this->model('Order');
        $orders = $orderModel->getAll();
        $this->view('admin/order/index', ['orders' => $orders]);
    }

    public function detail($id = 0)
    {
        $this->requireAdmin();
        $orderModel = $this->model('Order');
        $orderDetailModel = $this->model('OrderDetail');

        $order = $orderModel->getById($id);

        if (!$order) {
            return $this->view('admin/order/message', ['message' => 'Không tìm thấy đơn hàng']);
        }

        $details = $orderDetailModel->getDetailsByOrderId($id);

        return $this->view('admin/order/detail', [
            'order' => $order,
            'details' => $details
        ]);
    }

    public function updateStatus() {
    require_once __DIR__ . '/../../core/Database.php';
    $db = \Database::connect();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $orderId = intval($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        $allowed = ['đang chờ', 'đã xác nhận', 'đang vận chuyển', 'đã nhận hàng', 'hủy'];
        if ($orderId > 0 && in_array($status, $allowed)) {
            $stmt = mysqli_prepare($db, "UPDATE orders SET status = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'si', $status, $orderId);
            mysqli_stmt_execute($stmt);
        }
    }

    // Redirect để tránh gửi lại form nếu refresh
    header('Location: admin.php?url=order/index');
    exit();
}

    private function requireAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . BASE_URL . "/index.php?url=auth/login");
            exit();
        }
    }
}
