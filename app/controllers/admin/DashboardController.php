<?php

namespace admin;

use Controller;
require_once __DIR__ . '/../../core/Database.php';
use PDO;

class DashboardController extends Controller {
    public function index() {
        $db = \Database::connect();

        // Helper function: lấy 1 giá trị duy nhất
        function getValue($db, $query, $params = []) {
            $stmt = $db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        }

        $total_orders   = getValue($db, "SELECT COUNT(*) as total FROM orders");
        $total_users    = getValue($db, "SELECT COUNT(*) as total FROM users");
        $total_revenue  = getValue($db, "SELECT SUM(total_price) as total FROM orders WHERE status = 'đã xác nhận'");
        $total_categories = getValue($db, "SELECT COUNT(*) as total FROM categories");
        $total_brands     = getValue($db, "SELECT COUNT(*) as total FROM brands");
        $total_pending_orders = getValue($db, "SELECT COUNT(*) as total FROM orders WHERE status = 'đang chờ'");
        $total_contacts = getValue($db, "SELECT COUNT(*) as total FROM contacts");
        $total_admins = getValue($db, "SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
        $total_normal_users = getValue($db, "SELECT COUNT(*) as total FROM users WHERE role = 'customer'");
        $total_products = getValue($db, "SELECT COUNT(*) as total FROM products");
        $total_reviews = getValue($db, "SELECT COUNT(*) as total FROM reviews");

        // ✅ Dữ liệu biểu đồ doanh thu 7 ngày gần nhất
        $sales_labels = [];
        $sales_data = [];

        $sales_stmt = $db->prepare("
            SELECT DATE(created_at) AS day, SUM(total_price) AS revenue
            FROM orders
            WHERE status = 'đã xác nhận' AND created_at >= CURRENT_DATE - INTERVAL '6 days'
            GROUP BY day
            ORDER BY day ASC
        ");
        $sales_stmt->execute();
        $sales_result = $sales_stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($sales_result as $row) {
            $sales_labels[] = $row['day'];
            $sales_data[]   = (int)$row['revenue'];
        }

        // ✅ Biểu đồ người dùng
        $user_roles = [
            'Admin' => $total_admins,
            'Khách hàng' => $total_normal_users
        ];

        // ✅ Biểu đồ phân loại sản phẩm theo danh mục
        $category_labels = [];
        $category_counts = [];

        $category_stmt = $db->prepare("
            SELECT categories.name AS category, COUNT(products.id) AS count
            FROM products
            JOIN categories ON products.category_id = categories.id
            GROUP BY categories.name
        ");
        $category_stmt->execute();
        $categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categories as $row) {
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
