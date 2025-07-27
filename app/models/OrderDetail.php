<?php

class OrderDetail
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function create($order_id, $product_id, $quantity, $price)
    {
        $stmt = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
        $subtotal = $price * $quantity;
        $stmt->bind_param("iiidd", $order_id, $product_id, $quantity, $price, $subtotal);

        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi thêm chi tiết đơn hàng: " . $stmt->error);
        }
    }

    public function saveDetails($order_id, $cart)
    {
        foreach ($cart as $product_id => $quantity) {
            $product_id = intval($product_id);
            $quantity = intval($quantity);

            // Truy giá
            $result = mysqli_query($this->db, "SELECT price, discount_price FROM products WHERE id = $product_id");
            $product = mysqli_fetch_assoc($result);

            if (!$product) continue;

            $price = ($product['discount_price'] > 0) ? $product['discount_price'] : $product['price'];
            $subtotal = $price * $quantity;

            $stmt = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiidd", $order_id, $product_id, $quantity, $price, $subtotal);

            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi lưu chi tiết đơn hàng: " . $stmt->error);
            }
        }
    }

    public function getDetailsByOrderId($order_id)
    {
        $stmt = $this->db->prepare("
            SELECT od.*, p.name, p.image 
            FROM order_details od 
            JOIN products p ON od.product_id = p.id 
            WHERE od.order_id = ?
        ");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
