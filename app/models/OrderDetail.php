<?php

class OrderDetail
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect(); // PDO
    }

    public function create($order_id, $product_id, $quantity, $price)
    {
        $subtotal = $price * $quantity;
        $stmt = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price, subtotal) 
                                    VALUES (:order_id, :product_id, :quantity, :price, :subtotal)");
        return $stmt->execute([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal
        ]);
    }

   public function saveDetails($order_id, $cart)
{
    foreach ($cart as $product_id => $quantity) {
        $product_id = intval($product_id);
        $quantity = intval($quantity);

        // Truy giá
        $stmt = $this->db->prepare("SELECT price, discount_price FROM products WHERE id = :id");
        $stmt->execute(['id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) continue;

        $price = floatval(($product['discount_price'] ?? 0) > 0 ? $product['discount_price'] : $product['price']);
        $subtotal = $price * $quantity;

        $stmt = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price, subtotal) VALUES (:order_id, :product_id, :quantity, :price, :subtotal)");
        $stmt->execute([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal
        ]);
    }
}


    public function getDetailsByOrderId($order_id)
    {
        $stmt = $this->db->prepare("
            SELECT od.*, p.name, p.image 
            FROM order_details od 
            JOIN products p ON od.product_id = p.id 
            WHERE od.order_id = :order_id
        ");
        $stmt->execute(['order_id' => $order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
