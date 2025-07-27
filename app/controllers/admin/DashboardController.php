<?php

namespace admin;

use Controller;
require_once __DIR__ . '/../../core/Database.php';


class DashboardController extends Controller {
    public function index() {
    require_once __DIR__ . '/../../core/Database.php';
    $db = \Database::connect();

    $total_orders   = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM orders"))['total'];
    $total_users    = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM users"))['total'];
    $total_revenue  = mysqli_fetch_assoc(mysqli_query($db, "SELECT SUM(total_price) as total FROM orders WHERE status='đã xác nhận'"))['total'] ?? 0;
    $total_categories = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM categories"))['total'];
    $total_brands     = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM brands"))['total'];
    $total_pending_orders = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM orders WHERE status = 'đang chờ'"))['total'];
    $total_contacts = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM contacts"))['total'];

    $total_admins = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM users WHERE role = 'admin'"))['total'];
    $total_normal_users = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM users WHERE role = 'customer'"))['total'];
    $total_products = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM products"))['total'];
    $total_reviews = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as total FROM reviews"))['total'];   


    // Dữ liệu biểu đồ doanh thu 7 ngày gần nhất
        $sales_labels = [];
        $sales_data = [];

        $sales_query = mysqli_query($db, "
            SELECT DATE(created_at) AS day, SUM(total_price) AS revenue
            FROM orders
            WHERE status = 'đã xác nhận' AND created_at >= CURDATE() - INTERVAL 6 DAY
            GROUP BY DATE(created_at)
            ORDER BY day ASC
        ");
        while ($row = mysqli_fetch_assoc($sales_query)) {
            $sales_labels[] = $row['day'];
            $sales_data[] = (int)$row['revenue'];
        }

        // Biểu đồ người dùng
        $user_roles = [
            'Admin' => $total_admins,
            'Khách hàng' => $total_normal_users
        ];

        // Biểu đồ phân loại sản phẩm theo danh mục
        $category_labels = [];
        $category_counts = [];

        $category_query = mysqli_query($db, "
            SELECT categories.name AS category, COUNT(products.id) AS count
            FROM products
            JOIN categories ON products.category_id = categories.id
            GROUP BY category
        ");
        while ($row = mysqli_fetch_assoc($category_query)) {
            $category_labels[] = $row['category'];
            $category_counts[] = (int)$row['count'];
        }

    $this->view('admin/dashboard/index', [
        'total_orders'     => $total_orders,
        'total_users'      => $total_users,
        'total_revenue'    => $total_revenue,
        'total_categories' => $total_categories,
        'total_brands'     => $total_brands,
        'total_pending_orders' => $total_pending_orders,
        'total_contacts'   => $total_contacts,
        'total_admins'     => $total_admins,
        'total_normal_users' => $total_normal_users,
        'total_products'   => $total_products,
        'total_reviews'    => $total_reviews,
        'sales_labels'        => $sales_labels,
        'sales_data'          => $sales_data,
        'user_roles'          => $user_roles,
        'category_labels'     => $category_labels,
        'category_counts'     => $category_counts
    ]);
}

}
