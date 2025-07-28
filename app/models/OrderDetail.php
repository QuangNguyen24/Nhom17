<?php

class OrderDetail {
    private $db;

    public function __construct() {
        $this->db = Database::connect(); // PDO connection
    }

    public function create($order_id, $product_id, $quantity, $price) {
        $subtotal = $price * $quantity;

        $sql = "INSERT INTO order_details (order_id, product_id, quantity, price, subtotal)
                VALUES (:order_id, :product_id, :quantity, :price, :subtotal)";
        $stmt = $this->db->prepare($sql);
        
        try {
            $stmt->execute([
                'order_id' => $order_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal
            ]);
        } catch (PDOException $e) {
            die("Lỗi khi tạo chi tiết đơn hàng: " . $e->getMessage());
        }
    }

    public function saveDetails($order_id, $cart) {
        foreach ($cart as $product_id => $quantity) {
            $product_id = intval($product_id);
            $quantity = intval($quantity);

            // Truy giá sản phẩm
            $stmt = $this->db->prepare("SELECT price, discount_price FROM products WHERE id = :id");
            $stmt->execute(['id' => $product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) continue;

            $price = ($product['discount_price'] > 0) ? $product['discount_price'] : $product['price'];
            $subtotal = $price * $quantity;

            // Lưu chi tiết đơn hàng
            $insert = "INSERT INTO order_details (order_id, product_id, quantity, price, subtotal)
                       VALUES (:order_id, :product_id, :quantity, :price, :subtotal)";
            $stmtInsert = $this->db->prepare($insert);

            try {
                $stmtInsert->execute([
                    'order_id' => $order_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal
                ]);
            } catch (PDOException $e) {
                die("Lỗi khi lưu chi tiết đơn hàng: " . $e->getMessage());
            }
        }
    }

    public function getDetailsByOrderId($order_id) {
        $sql = "
            SELECT od.*, p.name, p.image 
            FROM order_details od 
            JOIN products p ON od.product_id = p.id 
            WHERE od.order_id = :order_id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['order_id' => $order_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
